<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use phpDocumentor\Reflection\Types\Boolean;


class Materiel extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'marque',
        'modele',
        'numero_serie',
        'est_disponible',
        'est_fonctionnel',
        'date_fabrication',
        'date_amortissement',
        'est_amorti',];
   // private mixed $est_disponible;

    public function attributions(): HasMany
    {
        return $this->hasMany(Attribution::class);
    }

    // Mutateur pour mettre à jour la date d'amortissement automatiquement
    public function setDateFabricationAttribute($value): void
    {
        $this->attributes['date_fabrication'] = $value;

        if ($value) {
            $this->attributes['date_amortissement'] = Carbon::parse($value)->addYears(3);
        }
    }

    // Accessor pour déterminer si le matériel est amorti
    public function getEstAmortiAttribute(): bool
    {
        if ($this->date_amortissement) {
            return Carbon::now()->greaterThan($this->date_amortissement);
        }

        return false;
    }

    public function getLastRestitutionDate()
    {
        return $this->attributions()
            ->whereNotNull('date_restitution') // Filtre les attributions qui ont une date de restitution
            ->orderBy('date_restitution', 'desc') // Trie par la date de restitution la plus récente
            ->first()
            ?->date_restitution; // Récupère la première attribution avec la date la plus récente

    }
}
