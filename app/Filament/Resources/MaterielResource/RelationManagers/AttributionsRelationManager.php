<?php

namespace App\Filament\Resources\MaterielResource\RelationManagers;

use App\Models\Attribution;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttributionsRelationManager extends RelationManager
{
    protected static string $relationship = 'attributions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employe_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
           // ->query(fn (Builder $query) => $query->with('materiel')) // Charge la relation materiel
            //->recordTitleAttribute('employe_id')
            ->columns([

                Tables\Columns\TextColumn::make('employe.nom_complet')
                    ->label('Employé'),
                    //->visible(fn (?Attribution $record) => $record && $record->materiel && $record->materiel->type === 'ordinateur'),

                Tables\Columns\BooleanColumn::make('materiel.est_disponible')
                    ->label('Disponible'),

                Tables\Columns\TextColumn::make('service')
                    ->label('Service'), // Vérification si 'materiel' n'est pas null
                   // ->visible(fn (?Attribution $record) => $record && $record->materiel && $record->materiel->type !== 'ordinateur'), // Vérifie si le record et la relation materiel existent, puis vérifie le type

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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
