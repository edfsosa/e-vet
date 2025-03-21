<?php

namespace App\Filament\Resources\OwnerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PetsRelationManager extends RelationManager
{
    protected static string $relationship = 'pets';
    protected static ?string $modelLabel = 'mascota';
    protected static ?string $title = 'Mascotas asociadas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('ID information'))
                    ->columns(3)
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
                        Forms\Components\DatePicker::make('birthdate')
                            ->translateLabel()
                            ->required()
                            ->native(false)
                            ->minDate(now()->subYears(25))
                            ->maxDate(now()),
                        Forms\Components\Radio::make('gender')
                            ->translateLabel()
                            ->required()
                            ->options([
                                'Male' => 'Macho',
                                'Female' => 'Hembra',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                    ]),

                Section::make(__('More information'))
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('size')
                            ->translateLabel()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->options([
                                'Giant' => __('Giant'),
                                'Big' => __('Big'),
                                'Medium' => __('Medium'),
                                'Small' => __('Small'),
                                'Tiny' => __('Tiny'),
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('weight')
                            ->translateLabel()
                            ->suffix('kg')
                            ->required()
                            ->numeric()
                            ->inputMode('decimal')
                            ->minValue(0.1)
                            ->maxValue(150),
                        Forms\Components\TextInput::make('fur')
                            ->label(__('Pelage'))
                            ->string()
                            ->required(),
                        Forms\Components\Radio::make('reproduction')
                            ->translateLabel()
                            ->required()
                            ->columnSpanFull()
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
                        Forms\Components\Toggle::make('active')
                            ->translateLabel()
                            ->hiddenOn('create')
                            ->onColor('success')
                            ->offColor('danger')
                            ->inline(false),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
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
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = Auth::id();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
