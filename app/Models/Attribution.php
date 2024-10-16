<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use phpDocumentor\Reflection\Types\Boolean;

class Attribution extends Model
{
    use HasFactory;

    /**
     * @var \Illuminate\Support\Carbon|mixed
     */
   // public mixed $date_restitution;
    protected $fillable = ['materiel_id', 'employe_id', 'service', 'date_attribution', 'date_restitution'];


    public function materiel(): BelongsTo
    {
        return $this->belongsTo(Materiel::class);
    }

    public function employe() :BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }

    /**
     * @return bool
     */
//    public function isRestitue(): Boolean
//    {
//        return !is_null($this->date_restitution);
//    }

    protected static function booted(): void
    {
        // Lorsqu'une attribution est enregistrée, on met à jour la disponibilité du matériel
        static::saving(function ($attribution) {
            // Si le matériel est attribué, il devient indisponible
            if (is_null($attribution->date_restitution)) {
                $materiel = Materiel::query()->find($attribution->materiel_id);
                if ($materiel) {
                    $materiel->est_disponible = false;
                    $materiel->save();
                }
            }
        });

        // Après la sauvegarde, on met à jour la disponibilité lors de la restitution
        static::saved(function ($attribution) {
            if (!is_null($attribution->date_restitution)) {
                $materiel = Materiel::query()->find($attribution->materiel_id);
                if ($materiel) {
                    $materiel->est_disponible = true;
                    $materiel->save();
                }
            }
        });
    }

}
