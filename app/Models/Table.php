<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    // Autres propriétés du modèle

    protected $fillable = [
        'numero',  // Ajoute 'numero' ici
        // Autres champs de la table si nécessaire
    ];
}

