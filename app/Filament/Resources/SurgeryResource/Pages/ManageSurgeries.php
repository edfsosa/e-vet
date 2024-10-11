<?php

namespace App\Filament\Resources\SurgeryResource\Pages;

use App\Filament\Resources\SurgeryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageSurgeries extends ManageRecords
{
    protected static string $resource = SurgeryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->mutateFormDataUsing(function (array $data): array {
                $data['user_id'] = Auth::id();

                return $data;
            })
        ];
    }
}
