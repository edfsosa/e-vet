<?php

namespace App\Filament\Widgets;

use App\Models\Pet;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PetSpeciesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Perros', Pet::query()->where('species', 'Perro')->count()),
            Stat::make('Gatos', Pet::query()->where('species', 'Gato')->count()),
            Stat::make('Total', Pet::all()->count()),
        ];
    }
}
