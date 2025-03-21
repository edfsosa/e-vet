<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultationResource\Pages;
use App\Filament\Resources\ConsultationResource\RelationManagers;
use App\Models\Consultation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;
    protected static ?string $navigationGroup = 'Procedures';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'consulta';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('anamnesis')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->autosize()
                    ->required(),
                Forms\Components\Textarea::make('diagnosis')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->autosize()
                    ->required(),
                Forms\Components\Textarea::make('treatment')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->autosize()
                    ->required(),
                Forms\Components\Textarea::make('observation')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->autosize()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->numeric(),
                Tables\Columns\TextColumn::make('pet.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                /* Tables\Columns\TextColumn::make('anamnesis')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(), */
                Tables\Columns\TextColumn::make('diagnosis')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageConsultations::route('/'),
        ];
    }
}
