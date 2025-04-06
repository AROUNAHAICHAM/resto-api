<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\ServeurController;
use App\Http\Controllers\Api\CategoriePlatController;
use App\Http\Controllers\Api\PlatController;
use App\Http\Controllers\Api\CommandeController;

// Routes pour les tables
Route::apiResource('tables', TableController::class);
Route::delete('tables/destroy-all', [TableController::class, 'destroyAll']);

// Routes pour les serveurs
Route::apiResource('serveurs', ServeurController::class);
Route::delete('serveurs/destroy-all', [ServeurController::class, 'destroyAll']);

// Routes pour les catégories de plats
Route::apiResource('categorie-plats', CategoriePlatController::class);
Route::delete('categorie-plats/destroy-all', [CategoriePlatController::class, 'destroyAll']);

// Routes pour les plats
Route::apiResource('plats', PlatController::class);

// Routes pour les commandes
Route::apiResource('commandes', CommandeController::class);
