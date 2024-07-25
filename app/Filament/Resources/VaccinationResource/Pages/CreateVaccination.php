<?php

namespace App\Filament\Resources\VaccinationResource\Pages;

use App\Filament\Resources\VaccinationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVaccination extends CreateRecord
{
    protected static string $resource = VaccinationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
