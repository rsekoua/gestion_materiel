<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterielResource\Pages;
use App\Filament\Resources\MaterielResource\RelationManagers;
use App\Models\Materiel;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterielResource extends Resource
{
    protected static ?string $model = Materiel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->required()
                    ->label('Type de matériel')
                    ->options([
                        'ordinateur' => 'Ordinateur',
                        'imprimante' => 'Imprimante',
                        'videoprojecteur' => 'Vidéo Projecteur'
                    ])
                    ->searchable(),
                Forms\Components\TextInput::make('marque')
                    ->required()
                    ->label('Marque'),
                Forms\Components\TextInput::make('modele')
                    ->required()
                    ->label('Modèle'),
                Forms\Components\TextInput::make('numero_serie')
                    ->required()
                   // ->unique()
                    ->label('Numéro de série'),
                Forms\Components\Toggle::make('est_disponible')
                    ->default(true)
                    ->label('Disponible'),
                Toggle::make('est_fonctionnel')
                    ->label('Fonctionnel')
                    ->default(true)
                    ->required(),

                DatePicker::make('date_fabrication')
                    ->label('Date de Fabrication')
                    ->required()
                    ->reactive() // Pour mettre à jour automatiquement la date d'amortissement
                    ->afterStateUpdated(function (callable $set, $state) {
                        // Calculer automatiquement la date d'amortissement lorsque la date de fabrication est définie
                        if ($state) {
                            $set('date_amortissement', \Carbon\Carbon::parse($state)->addYears(3));
                        }
                    }),
                DatePicker::make('date_amortissement')
                    ->label('Date d\'Amortissement')
                    ->disabled(), // Champ non modifiable car calculé automatiquement

//                Toggle::make('est_amorti')
//                    ->label('Est Amorti')
//                    ->disabled() // Calculé dynamiquement, donc seulement affiché
//                    ->dehydrated(false) // Empêche de l'enregistrer dans la base de données
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Type de matériel')
                    ->sortable(),
                Tables\Columns\TextColumn::make('marque')
                    ->label('Marque'),
                Tables\Columns\TextColumn::make('modele')
                    ->label('Modèle'),
                Tables\Columns\TextColumn::make('numero_serie')
                    ->label('Numéro de série')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('est_disponible')
                    ->label('Disponible'),
                Tables\Columns\BooleanColumn::make('est_fonctionnel')
                    ->label('fonctionnel'),
                Tables\Columns\TextColumn::make('date_fabrication')
                    ->label('Date de fabrication')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_amortissement')
                    ->label('Date d\'Amortissement')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('est_amorti')
                    ->label('Amorti'),




            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMateriels::route('/'),
            'create' => Pages\CreateMateriel::route('/create'),
            'edit' => Pages\EditMateriel::route('/{record}/edit'),
        ];
    }
}
