<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use App\Models\Category;
use App\Models\LastNews;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LastNewsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LastNewsResource\RelationManagers;

class LastNewsResource extends Resource
{
    protected static ?string $model = LastNews::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()->schema([
                Fieldset::make(__('Last News'))
                ->schema([
                TextInput::make('title')
                ->label(__('News'))
                    ->required()
                    ->unique(),    
                
                    Select::make('category_id')
                    ->label(__('Category'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->options(Category::all()->pluck('name', 'id'))
                    ->reactive() // لجعل الحقل ديناميكيًا بناءً على التغيير
                    ->afterStateUpdated(fn ($state, callable $set) => $set('post_id', null)), // تفريغ حقل Post عند تغيير Category
            

                    Select::make('post_id')
    ->label(__('Post'))
    ->required()
    ->searchable()
    ->preload()
    ->options(function ($get) {
        $categoryId = $get('category_id');
        if ($categoryId) {
            return Post::where('category_id', $categoryId)->pluck('title', 'id');
        }
        return [];
    })
                ])
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('News'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label(__('Category'))
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                    TextColumn::make('post.title')
                    ->label(__('Post'))
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label(__('Category'))
                    ->relationship('category', 'name'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLastNews::route('/'),
            'create' => Pages\CreateLastNews::route('/create'),
            'edit' => Pages\EditLastNews::route('/{record}/edit'),
        ];
    }


        
    public static function getNavigationLabel(): string
    {
        return __('Last Newss');
    }
    public static function getPluralLabel(): string
    {
        return  __('Last Newss'); 
    }
    public static function getModelLabel(): string
    {
        return  __('Last News'); 
    }
    
    public static function getNavigationGroup(): ?string
    {
        return __('Blog'); // استخدام الدالة __() لجلب الترجمة
    }
}
