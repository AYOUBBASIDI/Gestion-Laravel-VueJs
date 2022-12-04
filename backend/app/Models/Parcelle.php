<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcelle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'village_id',
        'proprietaire_id',
        'numero',
        'date_delimitation',
        'signature',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Village()
    {
        return $this->belongsTo(Village::class);
    }

    public function Proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }

}
