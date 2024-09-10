<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Setting;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
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
use App\Filament\Resources\SettingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SettingResource\RelationManagers;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Card::make()->schema([

                //     Fieldset::make(__('Contacts'))
                //     ->schema([
                //         TextInput::make('title')
                //         ->label(__('Site Name'))
                //         ->required(),

                //         TextInput::make('address')
                //         ->label(__('Location'))
                //         ->required(),

                //         FileUpload::make('logo')
                //         ->label(__('Logo'))
                //         ->image() // تحقق أن الملف صورة
                //         ->maxSize(2048) // الحجم الأقصى للملف 2 ميجابايت
                //         ->required() // اجعل الحقل مطلوبًا إذا كان ضروريًا
                //         ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048']) // قواعد التحقق الإضافية
                //         ->directory('logo'),

                //         FileUpload::make('favicon')
                //         ->label(__('Favicon'))
                //         ->image() // تحقق أن الملف صورة
                //         ->maxSize(512) // الحجم الأقصى للملف 512 كيلوبايت
                //         ->required() // اجعل الحقل مطلوبًا إذا كان ضروريًا
                //         ->rules(['mimes:ico,png', 'max:512']) // قواعد التحقق الإضافية
                //         ->directory('favicon'),
                        
                //         TextInput::make('phone1')
                //         ->label(__('Phone 1'))
                //         ->required() // اجعل الحقل مطلوبًا
                //         ->rules([
                //             'regex:/^0[0-9]{10}$/', // تحقق من النمط
                //             Rule::unique('settings', 'phone1') // تحقق من الفريدة
                //                 ->ignore(request()->route('record')), // تجاهل السجل الحالي عند التحديث
                //         ])
                //         ->placeholder(__('Enter a valid phone number'))
                //         ->helperText(__('The phone number must be 11 digits and start with 0.')),

                //         TextInput::make('phone2')
                //         ->label(__('Phone 2'))
                //         ->rules([
                //             'regex:/^0[0-9]{10}$/', // تحقق من النمط
                //             Rule::unique('settings', 'phone2') // تحقق من الفريدة
                //                 ->ignore(request()->route('record')), // تجاهل السجل الحالي عند التحديث
                //         ])
                //         ->placeholder(__('Enter a valid phone number'))
                //         ->helperText(__('The phone number must be 11 digits and start with 0.')),
                //     ]),

                    
                //     Fieldset::make(__('Social Media'))
                //     ->schema([
                        

                //         TextInput::make('facebook')
                //         ->label(__('Facebook'))
                //         ->url()
                //         ->suffixIcon('heroicon-m-globe-alt'),

                //         TextInput::make('youtube')
                //         ->label(__('Youtube'))
                //         ->url()
                //         ->suffixIcon('heroicon-m-globe-alt'),

                //         TextInput::make('twitter')
                //         ->label(__('Twitter'))
                //         ->url()
                //         ->suffixIcon('heroicon-m-globe-alt'),

                //         TextInput::make('instagram')
                //         ->label(__('Instagram'))
                //         ->url()
                //         ->suffixIcon('heroicon-m-globe-alt'),

                //         TextInput::make('tiktok')
                //         ->label(__('Tiktok'))
                //         ->url()
                //         ->suffixIcon('heroicon-m-globe-alt'),

                //     ]),

                // ])

                Card::make()->schema([
                    Wizard::make([
                        Wizard\Step::make(__('Basic Information'))
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('Site Name'))
                                    ->required(),

                                TextInput::make('address')
                                    ->label(__('Location'))
                                    ->required(),  
                            ]),
                        Wizard\Step::make(__('Contacts'))
                            ->schema([
                                TextInput::make('phone1')
                                    ->label(__('Phone 1'))
                                    ->required() // اجعل الحقل مطلوبًا
                                    ->rules([
                                        'regex:/^0[0-9]{10}$/', // تحقق من النمط
                                        Rule::unique('settings', 'phone1') // تحقق من الفريدة
                                            ->ignore(request()->route('record')), // تجاهل السجل الحالي عند التحديث
                                    ])
                                    ->placeholder(__('Enter a valid phone number'))
                                    ->helperText(__('The phone number must be 11 digits and start with 0.')),

                                    TextInput::make('phone2')
                                    ->label(__('Phone 2'))
                                    ->rules([
                                        'regex:/^0[0-9]{10}$/', // تحقق من النمط
                                        Rule::unique('settings', 'phone2') // تحقق من الفريدة
                                            ->ignore(request()->route('record')), // تجاهل السجل الحالي عند التحديث
                                    ])
                                    ->placeholder(__('Enter a valid phone number'))
                                    ->helperText(__('The phone number must be 11 digits and start with 0.')), 
                            ]),
                        Wizard\Step::make(__('Midea'))
                        ->schema([
                                FileUpload::make('logo')
                                ->label(__('Logo'))
                                ->image() // تحقق أن الملف صورة
                                ->maxSize(2048) // الحجم الأقصى للملف 2 ميجابايت
                                ->required() // اجعل الحقل مطلوبًا إذا كان ضروريًا
                                ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048']) // قواعد التحقق الإضافية
                                ->directory('logo'),

                                FileUpload::make('favicon')
                                ->label(__('Favicon'))
                                ->image() // تحقق أن الملف صورة
                                ->maxSize(512) // الحجم الأقصى للملف 512 كيلوبايت
                                ->required() // اجعل الحقل مطلوبًا إذا كان ضروريًا
                                ->rules(['mimes:ico,png', 'max:512']) // قواعد التحقق الإضافية
                                ->directory('favicon'),
                        ]),    

                        Wizard\Step::make(__('Social Media'))
                        ->schema([
                            Repeater::make('social_midea')
                                ->label(__('Social Media'))
                                ->schema([
                                    TextInput::make('social_midea')
                                        ->label(__('Social Media'))
                                        ->url()
                                        ->suffixIcon('heroicon-m-globe-alt'),
                                ])
                                ->cloneable(),
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
                    ])->skippable()
            ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                ->label(__('Site Name'))
                                 ->searchable()
                                 ->sortable(),

                TextColumn::make('phone1')
                ->label(__('Phone 1'))
                                 ->searchable()
                                 ->sortable(),

                TextColumn::make('address')
                ->label(__('Location'))
                    ->searchable()
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }

    
// الترجمة
    public static function getNavigationLabel(): string
    {
        return __('Settings');
    }
    public static function getPluralLabel(): string
    {
        return  __('Settings'); 
    }
    public static function getModelLabel(): string
    {
        return  __('Setting'); 
    }
    public static function getNavigationGroup(): ?string
    {
        return __('Blog');
    }
//  لاخفاء زرار الاضافة بعد اضافه اول صف فى الداتا بيز
    public static function canCreate(): bool
    {
        return !self::hasQueries();
    }

    protected static function hasQueries(): bool
    {
        return Setting::count() > 0;
    }

    
}
