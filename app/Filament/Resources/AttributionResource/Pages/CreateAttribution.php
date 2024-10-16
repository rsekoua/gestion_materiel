<?php

namespace App\Filament\Resources\AttributionResource\Pages;

use App\Filament\Resources\AttributionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAttribution extends CreateRecord
{
    protected static string $resource = AttributionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    protected function getCreatedNotification(): ?Notification
    {
        return Notification:: make()
            ->success()
            ->title('Materiel attribué')
            ->body('Le materiel a été attribué avec succès.');
    }
}
