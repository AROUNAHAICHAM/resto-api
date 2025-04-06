<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        'table_id',
        'serveur_id',
        'statut',
        'plats',
    ];

    protected $casts = [
        'plats' => 'array', // Assure que plats est traité comme un tableau JSON
    ];
}
