<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoriePlat;
use Illuminate\Http\Request;

class CategoriePlatController extends Controller
{
    public function index()
    {
        $categories = CategoriePlat::all();
        return response()->json([
            'message' => 'Liste des catégories récupérée avec succès',
            'data' => $categories
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:categorie_plats',
        ]);

        $categoriePlat = CategoriePlat::create($request->all());
        return response()->json([
            'message' => 'Catégorie créée avec succès',
            'data' => $categoriePlat
        ], 201);   
    }

    public function show($id)
    {
        $categoriePlat = CategoriePlat::findOrFail($id);
        return response()->json([
            'message' => 'Catégorie récupérée avec succès',
            'data' => $categoriePlat
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|unique:categorie_plats,nom,' . $id,
        ]);

        $categoriePlat = CategoriePlat::findOrFail($id);
        $categoriePlat->update($request->all());
        return response()->json([
            'message' => 'Catégorie mise à jour avec succès',
            'data' => $categoriePlat
        ], 200);
    }

    public function destroy($id)
    {
        $categoriePlat = CategoriePlat::findOrFail($id);
        $categoriePlat->delete();
        return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ], 200); // J’ai choisi 200, mais 204 est aussi valide
    }

    public function destroyAll()
    {
        CategoriePlat::truncate();
        return response()->json([
            'message' => 'Toutes les catégories ont été supprimées avec succès'
        ], 200);
    }
}
