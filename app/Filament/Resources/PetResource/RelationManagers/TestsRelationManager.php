<?php

namespace App\Filament\Resources\PetResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TestsRelationManager extends RelationManager
{
    protected static string $relationship = 'tests';
    protected static ?string $modelLabel = 'prueba laboratorial';
    protected static ?string $title = 'Pruebas Laboratoriales';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->translateLabel()
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->maxDate(now()),
                Forms\Components\Select::make('type')
                    ->translateLabel()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->options([
                        'Hematología' => __('Hematology'),
                        'Bioquímica' => __('Biochemistry'),
                        'Inmunología' => __('Immunology'),
                        'Microbiología' => __('Microbiology'),
                        'Parasitología' => __('Parasitology'),
                        'Uroanálisis' => __('Urinalysis'),
                        'Coprología' => __('Fecal Analysis'),
                        'Cultivo' => __('Culture'),
                        'Prueba Rápida' => __('Rapid Test'),
                        'PCR' => __('PCR'),
                        'Serología' => __('Serology'),
                        'Otros' => __('Others'),
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('result')
                    ->label('Resultados')
                    ->multiple()
                    ->maxParallelUploads(1)
                    ->panelLayout('grid')
                    ->openable()
                    ->downloadable()
                    ->uploadingMessage('Subiendo archivo adjunto...')
                    ->maxFiles(5)
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Textarea::make('observation')
                    ->translateLabel()
                    ->autosize()
                    ->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->numeric(),
                Tables\Columns\TextColumn::make('date')
                    ->translateLabel()
                    ->date('d/m/Y')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->translateLabel()
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
                    ->dateTime('d/m/Y H:i')
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
