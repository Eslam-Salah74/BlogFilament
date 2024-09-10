<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource\Pages;
use Filament\Forms\Components\Select; 
use Filament\Tables\Columns\TextColumn; 

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__('Name'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->label(__('Email'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->label(__('Password'))
                    ->dehydrateStateUsing(fn ($state) => $state ? Hash::make($state) : null),

                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->label(__('Roles'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label(__('Name')),
                TextColumn::make('email')
                    ->searchable()
                    ->label(__('Email')),

                TextColumn::make('roles.name')
                    ->label(__('Roles'))
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                // يمكنك إضافة الفلاتر هنا إذا أردت
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            // العلاقات يمكن إضافتها هنا إذا أردت
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }


   
    public static function getNavigationLabel(): string
    {
        return __('Users');
    }
    public static function getPluralLabel(): string
    {
        return  __('Users'); 
    }
    public static function getModelLabel(): string
    {
        return  __('User'); 
    }
    public static function getNavigationGroup(): ?string
    {
        return __('Blog');
    }
}
