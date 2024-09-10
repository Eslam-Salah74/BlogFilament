<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\CategoryResource\RelationManagers\PostsRelationManager;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static ?string $navigationGroup = 'Blog';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                        Wizard::make([
                            Wizard\Step::make(__('Title'))
                                ->schema([
                                    TextInput::make('name')
                                        ->label(__('name'))
                                        ->required()
                                        ->unique() ,
                                        
                                    MarkdownEditor::make('description')
                                                ->label(__('description'))
                                                ->required(),

                                                Toggle::make('home')
                                                ->label(__('home'))
                                                // ->required()
                                                ->default(false)
                                                ->translateLabel(),

                                            Toggle::make('header')
                                                ->label(__('header'))
                                                ->required()
                                                ->default(true)
                                                ->translateLabel(),
                                            Toggle::make('footer')
                                                ->label(__('footer'))
                                                // ->required()
                                                ->default(false)
                                                ->translateLabel(),   
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
                        ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('name'))   
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label(__('description'))
                    ->searchable()
                    ->sortable()
                    ->limit(50) 
                    ->html()
                    ->wrap()
                    ->extraAttributes([
                        'style' => 'white-space: pre-wrap; word-wrap: break-word; max-width: 200px;', // يمكنك تعديل max-width حسب الحاجة
                    ]),
                    
            ])
            ->filters([
                //
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
            // PostsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

// الترجمة
    public static function getNavigationLabel(): string
    {
        return __('Categories');
    }
    public static function getPluralLabel(): string
    {
        return  __('Categories'); 
    }
    public static function getModelLabel(): string
    {
        return  __('Category'); 
    }
    public static function getNavigationGroup(): ?string
    {
        return __('Blog'); 
    }
}
