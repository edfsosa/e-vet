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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('ID info')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->hiddenOn('create')
                            ->readOnly(),
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('species')
                            ->required(),
                        Forms\Components\TextInput::make('breed')
                            ->required(),
                        Forms\Components\Radio::make('gender')
                            ->required()
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Forms\Components\DatePicker::make('birthdate')
                            ->required()
                            ->format('d/m/Y')
                            ->native(false)
                            ->minDate(now()->subYears(25))
                            ->maxDate(now()),
                    ]),

                Section::make('More info')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Radio::make('size')
                            ->required()
                            ->options([
                                'Giant' => 'Giant',
                                'Big' => 'Big',
                                'Medium' => 'Medium',
                                'Small' => 'Small',
                                'Tiny' => 'Tiny',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Forms\Components\TextInput::make('weight')
                            ->required()
                            ->numeric()
                            ->inputMode('decimal')
                            ->minValue(0, 1)
                            ->maxValue(150),
                        Forms\Components\TextInput::make('fur')
                            ->required(),
                        Forms\Components\Radio::make('reproduction')
                            ->required()
                            ->options([
                                'Normal' => 'Normal',
                                'Castrated' => 'Castrated',
                                'Sterilized' => 'Sterilized',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->imageEditor()
                            ->downloadable()
                            ->columnSpanFull()
                            ->uploadingMessage('Subiendo archivo adjunto...')
                            ->required(),
                        Forms\Components\Toggle::make('active')
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
