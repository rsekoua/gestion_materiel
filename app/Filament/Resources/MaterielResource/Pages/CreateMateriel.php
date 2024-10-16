<?php

namespace App\Filament\Resources\MaterielResource\Pages;

use App\Filament\Resources\MaterielResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMateriel extends CreateRecord
{
    protected static string $resource = MaterielResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Matériel Enregistré')
            ->body('Le matériel a été enregistré avec succès.');
    }

}
