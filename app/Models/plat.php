<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prix', 'categorie_id', 'photo'];

    public function commandes()
{
    return $this->belongsToMany(Commande::class, 'commande_plat')->withPivot('quantite')->withTimestamps();
}

}
