<?php

namespace App\Filament\Resources\EmployeResource\Pages;

use App\Filament\Resources\EmployeResource;
use Filament\Actions;

use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Filament\Resources\MaterielResource;


class CreateEmploye extends CreateRecord
{
    protected static string $resource = EmployeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification:: make()
            ->success()
            ->title('Employé Enregistré')
            ->body('L \'employé a été enregistré avec succès.');
    }

}
