<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employe extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'email', 'service'];

    public function attributions(): HasMany
    {
        return $this->hasMany(Attribution::class);
    }

    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }
}
