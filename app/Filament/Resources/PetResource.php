<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PetResource\Pages;
use App\Filament\Resources\PetResource\RelationManagers;
use App\Models\Pet;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Layout\Split;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'mascota';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make(__('ID information'))
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->label('ID')
                            ->hiddenOn('create')
                            ->readOnly(),
                        Forms\Components\TextInput::make('name')
                            ->translateLabel()
                            ->string()
                            ->required(),
                        Forms\Components\Select::make('species')
                            ->translateLabel()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->options([
                                'Canino' => __('Canine'),
                                'Felino' => __('Feline'),
                                'Roedor' => __('Rodent'),
                                'Ave' => __('Bird'),
                                'Equino' => __('Equine'),
                                'Bovino' => __('Bovine'),
                                'Pez' => __('Fish'),
                                'Reptil' => __('Reptile'),
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('breed')
                            ->translateLabel()
                            ->string()
                            ->required(),
                        Forms\Components\Radio::make('gender')
                            ->translateLabel()
                            ->required()
                            ->options([
                                'Male' => 'Macho',
                                'Female' => 'Hembra',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Forms\Components\DatePicker::make('birthdate')
                            ->translateLabel()
                            ->required()
                            ->native(false)
                            ->maxDate(now()),
                    ]),

                Section::make(__('More information'))
                    ->columns(2)
                    ->schema([
                        Forms\Components\Radio::make('size')
                            ->translateLabel()
                            ->required()
                            ->options([
                                'Giant' => __('Giant'),
                                'Big' => __('Big'),
                                'Medium' => __('Medium'),
                                'Small' => __('Small'),
                                'Tiny' => __('Tiny'),
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Forms\Components\TextInput::make('weight')
                            ->translateLabel()
                            ->required()
                            ->numeric()
                            ->inputMode('decimal')
                            ->minValue(0.1)
                            ->maxValue(150),
                        Forms\Components\TextInput::make('fur')
                            ->label(__('Pelage'))
                            ->required(),
                        Forms\Components\Radio::make('reproduction')
                            ->translateLabel()
                            ->required()
                            ->options([
                                'Normal' => __('Normal'),
                                'Castrated' => __('Castrated'),
                                'Sterilized' => __('Sterilized'),
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Forms\Components\FileUpload::make('image')
                            ->translateLabel()
                            ->image()
                            ->imageEditor()
                            ->downloadable()
                            ->columnSpanFull()
                            ->uploadingMessage('Subiendo archivo adjunto...')
                            ->required(),
                        Forms\Components\Select::make('owner_id')
                            ->translateLabel()
                            ->relationship('owner', 'full_name')
                            ->searchable(['full_name', 'ci'])
                            ->preload()
                            ->live()
                            ->required(),
                        Forms\Components\Toggle::make('active')
                            ->translateLabel()
                            ->hiddenOn('create')
                            ->onColor('success')
                            ->offColor('danger')
                            ->inline(false),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular(),
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('species')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('breed')
                    ->searchable()
                    ->sortable(),
                /* Tables\Columns\TextColumn::make('gender')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('birthdate')
                        ->date()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('size')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('weight')
                        ->numeric()
                        ->sortable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('fur')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('reproduction')
                        ->searchable()
                        ->sortable(), */
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->sortable(),
                /* Tables\Columns\TextColumn::make('owner.ci')
                        ->numeric()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('user.name')
                        ->numeric()
                        ->sortable(), */
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->selectCurrentPageOnly();
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VaccinationsRelationManager::class,
            RelationManagers\ConsultationsRelationManager::class,
            RelationManagers\SurgeriesRelationManager::class,
            RelationManagers\TestsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPets::route('/'),
            'create' => Pages\CreatePet::route('/create'),
            'edit' => Pages\EditPet::route('/{record}/edit'),
        ];
    }
}
