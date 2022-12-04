<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proprietaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'nationalite',
        'type_identite',
        'numero_identite',
        'adresse',
    ];

    public function Parcelles()
    {
        return $this->hasMany(Parcelle::class, 'proprietaire_id', 'id');
    }
}
