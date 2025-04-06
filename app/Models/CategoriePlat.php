<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriePlat extends Model
{
    protected $fillable = ['nom']; // Ajoute ces champs
    use HasFactory;
}
