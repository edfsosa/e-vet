<?php

namespace App\Filament\Resources\PetResource\Pages;

use App\Filament\Resources\PetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPets extends ListRecords
{
    protected static string $resource = PetResource::class;

    /*     protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
 */
    public function getTabs(): array
    {
        return [
            __('All') => Tab::make(),
            __('Actives') => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('active', true)),
            __('Inactives') => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('active', false)),
        ];
    }
}
