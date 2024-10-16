<?php

namespace App\Filament\Resources\MaterielResource\Pages;

use App\Filament\Resources\MaterielResource;
use App\Models\Materiel;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
//use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMateriels extends ListRecords
{
    protected static string $resource = MaterielResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tout le materiel'),
            'Ordinateurs' => Tab::make()
                            //->icon('heroicon-m-user-group')
                            ->badge(Materiel::query()->where('type', '=', 'ordinateur')->count())
                            ->modifyQueryUsing(fn ($query) =>$query->where('type', '=', 'ordinateur')),
            'Imprimantes' => Tab::make()
                //->icon('heroicon-m-user-group')
                ->badge(Materiel::query()->where('type', '=', 'imprimante')->count())
                ->modifyQueryUsing(fn ($query) =>$query->where('type', '=', 'imprimante')),
            'Vidéos Projecteurs' => Tab::make()
                //->icon('heroicon-m-user-group')
                ->badge(Materiel::query()->where('type', '=', 'videoprojecteur')->count())
                ->modifyQueryUsing(fn ($query) =>$query->where('type', '=', 'videoprojecteur')),
        ];
    }
}
