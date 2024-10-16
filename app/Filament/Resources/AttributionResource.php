<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributionResource\Pages;
use App\Filament\Resources\AttributionResource\RelationManagers;
use App\Models\Attribution;
use App\Models\Employe;
use App\Models\Materiel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttributionResource extends Resource
{
    protected static ?string $model = Attribution::class;
    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('materiel_id')
                    ->label('Matériel')
                    ->options(Materiel::query()
                        ->where('est_disponible', true)
                        ->where('est_fonctionnel', true)
                        ->pluck('numero_serie', 'id'))
                    ->required()
                    ->preload()
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated( function(callable $set, $state) {
                        $materiel = Materiel::query()->find($state);
                        if($materiel){
                            $set('materiel_type', $materiel->type);
                        } else {
                            $set('materiel_type', null);
                        }
                    })
                    ->afterStateHydrated( function(callable $set, $state) {
                        $materiel = Materiel::query()->find($state);
                        if($materiel){
                            $set('materiel_type', $materiel->type);
                        } else {
                            $set('materiel_type', null);
                        }
                    }),
                Forms\Components\Hidden::make('materiel_type'),

                Forms\Components\Select::make('employe_id')
                    ->label('Employé')
                    ->options(function () {
                        return Employe::all()->pluck('nom_complet', 'id');
                    })
                    ->preload()
                    ->searchable()
                    ->required(fn ($get) => $get('materiel_type') === 'ordinateur')
                    ->disabled(fn ($get) => $get('materiel_type') !== 'ordinateur')
                    ->hidden(fn ($get) => $get('materiel_type') !== 'ordinateur'),

                Forms\Components\TextInput::make('service')
                    ->label('Service')
                    ->required(fn ($get) => $get('materiel_type') !== 'ordinateur')
                    ->disabled(fn ($get) => $get('materiel_type') === 'ordinateur')
                    ->hidden(fn ($get) => $get('materiel_type') === 'ordinateur'),

                Forms\Components\DatePicker::make('date_attribution')
                    ->label('Date d\'attribution')
                    ->native(false)
                    ->required(),

                Forms\Components\DatePicker::make('date_restitution')
                    ->native(false)
                    ->label('Date de restitution'),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('materiel.type')
                    ->label('Type de matériel'),
                Tables\Columns\BooleanColumn::make('materiel.est_disponible')
                    ->label('Disponible'),
                Tables\Columns\TextColumn::make('materiel.numero_serie')
                    ->label('Numéro de série'),
                Tables\Columns\TextColumn::make('employe.nom')
                    ->label('Employé'),
                Tables\Columns\TextColumn::make('service')
                    ->label('Service'),
                Tables\Columns\TextColumn::make('date_attribution')
                    ->label('Date d\'attribution')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_restitution')
                    ->label('Date de restitution')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
               // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('restituer')
                    ->label('Restituer')
                    ->action(function (Attribution $record) {
                        $record->date_restitution = now();
                        $record->save();

                        // Met à jour la disponibilité du matériel
                        $materiel = Materiel::query()->find($record->materiel_id);
                        if ($materiel) {
                            $materiel->est_disponible = true;
                            $materiel->save();
                        }
                    })
                    ->color('success')
                    ->visible(fn ($record) => is_null($record->date_restitution)) // Le bouton est visible seulement si le matériel n'est pas encore restitué
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttributions::route('/'),
            'create' => Pages\CreateAttribution::route('/create'),
            'edit' => Pages\EditAttribution::route('/{record}/edit'),
        ];
    }
}
