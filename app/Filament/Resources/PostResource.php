<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\PostResource\Pages;
use Filament\Forms\Components\BelongsToSelect;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\Widgets\PostsChart;
use App\Filament\Resources\PostResource\Widgets\StatsPostOverview;
use App\Filament\Resources\PostResource\RelationManagers\TagsRelationManager;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Blog';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Card::make()->schema([
                    Wizard::make([
                            Wizard\Step::make(__('Title'))
                            ->schema([
                                Select::make('category_id')
                                    ->label(__('Category'))
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->relationship('category', 'name'),
                                TextInput::make('title')
                                    ->label(__('title'))
                                    ->required()
                                    ->unique('posts', 'title', fn ($record) => $record),
                                    
                                MarkdownEditor::make('sub_title')
                                            ->label(__('Subtitle'))
                                            ->required(),  
                            ]),
                            Wizard\Step::make(__('Contents'))
                            ->schema([
                                MarkdownEditor::make('sub_content')
                                            ->label(__('sub_content'))
                                            ->required(), 
                                MarkdownEditor::make('content')
                                    ->label(__('content'))
                                    ->required(),
  
                            ]),
                            Wizard\Step::make(__('Midea'))
                            ->schema([
                                FileUpload::make('img')
                                    ->label(__('img'))
                                    ->image() // تحقق أن الملف صورة
                                    ->maxSize(2048) // الحجم الأقصى للملف 2 ميجابايت
                                    ->required() // اجعل الحقل مطلوبًا إذا كان ضروريًا
                                    ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'])
                                    ->directory('Post') ,
                                    // Toggle::make('is_published')
                                    // ->label('Published')
                                    // ->default(false)
                                    // ->visible(fn ($record) => $record !== null),
                                    Hidden::make('user_id')
                                        ->default(fn () => Auth::user()->id),
                            ]),
                            Wizard\Step::make(__('SEO'))
                            ->schema([
                                Repeater::make('seo')
                                    ->label(__('SEO'))
                                    ->schema([
                                        TextInput::make('seo')
                                            ->label(__('SEO'))
                                            ->required(),
                                    ])
                                    ->cloneable(),
                            ]),
                            Wizard\Step::make(__('Meta'))
                            ->schema([
                                Repeater::make('meta')
                                    ->label(__('Meta'))
                                    ->schema([
                                        TextInput::make('meta')
                                            ->label(__('Meta'))
                                            ->required(),
                                    ])
                                    ->cloneable(),
                            ]),
                            Wizard\Step::make(__('Review the post'))
                            ->schema([ 
                                Toggle::make('is_published')
                                    ->label(__('published'))
                                    ->default(false)
                                    // سيظهر فقط أثناء التعديل
                            ])
                        ->visible(fn ($record) => $record !== null),
                    ])->skippable()
            ])
                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('title'))
                    ->searchable()
                    ->sortable(),

                    TextColumn::make('sub_title')
                    ->label(__('Subtitle'))
                    ->searchable()
                    ->sortable()
                    ->limit(50)  // يحد من عدد الأحرف المعروضة إلى 50
                    ->html() // يسمح بتطبيق CSS لتنسيق النص
                    ->wrap() // يتأكد من أن النص سينتقل إلى الأسطر التالية إذا كان طويلاً
                    ->extraAttributes([
                        'style' => 'white-space: pre-wrap; word-wrap: break-word; max-width: 200px;', // يمكنك تعديل max-width حسب الحاجة
                    ]),
                TextColumn::make('user.name')
                ->label(__('Article writer'))
                ->searchable()
                ->sortable()
                ->translateLabel(),
                TextColumn::make('category.name')
                    ->label(__('Category'))
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                    
                    IconColumn::make('is_published')
                ->label(__('published'))
                ->boolean()
                ->trueIcon('heroicon-s-check-circle')  // الأيقونة التي ستظهر إذا كانت القيمة true
                ->falseIcon('heroicon-s-x-circle')     // الأيقونة التي ستظهر إذا كانت القيمة false
                ->colors([
                    'success' => true, // لون الأيقونة للحالة true
                    'danger' => false, // لون الأيقونة للحالة false
                ])
                ->sortable(),
                
                // ImageColumn::make('img')
                // ->label(__('img')),
            ])
            ->filters([
                Filter::make('published')
                    ->query(fn (Builder $query): Builder => $query->where('is_published', true))
                    ->label(__('published')), // استخدم الترجمة إذا كنت ترغب في ذلك
    
                Filter::make('not_published')
                    ->query(fn (Builder $query): Builder => $query->where('is_published', false))
                    ->label(__('Draft')), // استخدم الترجمة إذا كنت ترغب في ذلك
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    EditAction::make(),
                    ViewAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // TagsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationLabel(): string
    {
        return __('Posts');
    }
    public static function getPluralLabel(): string
    {
        return  __('Posts'); 
    }
    public static function getModelLabel(): string
    {
        return  __('Post'); 
    }
    
    public static function getWidgets(): array
    {
        return [
            StatsPostOverview::class,
            // PostsChart::class,
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Blog'); // استخدام الدالة __() لجلب الترجمة
    }
}
