<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
    ];

    public function Parcelles()
    {
        return $this->hasMany(Parcelle::class, 'village_id', 'id');
    }

}
