<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Comment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\CommentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CommentResource\RelationManagers;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
{
    return $form->schema([
        Card::make()->schema([
            Fieldset::make(__('Comments'))
                    ->schema([
            Select::make('user_id')
            ->label(__('User'))
                ->required()
                ->searchable()
                ->preload()
                ->relationship('user', 'name'),
                
            Select::make('post_id')
            ->label(__('Post'))
                ->required()
                ->searchable()
                ->preload()
                ->relationship('post', 'title'),
                
            ]),
                MarkdownEditor::make('comment')
                ->label(__('Comment'))
                ->required(),
                    // ->translateLabel(),
        ]),
    ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('post.title')
                ->label(__('Post Title'))
                ->sortable(),
            Tables\Columns\TextColumn::make('user.name')
                ->label(__('User Name'))
                ->sortable(),
        ])
        ->filters([
            // Add filters if needed
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }

//  الترجمة
    public static function getNavigationLabel(): string
    {
        return __('Comments');
    }
    public static function getPluralLabel(): string
    {
        return  __('Comments'); 
    }
    public static function getModelLabel(): string
    {
        return  __('Comment'); 
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Blog'); 
    }
}
