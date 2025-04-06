<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Serveur;
use Illuminate\Http\Request;

class ServeurController extends Controller
{
    public function index()
    {
        $serveurs = Serveur::all();
        return response()->json([
            'message' => 'Liste des serveurs récupérée avec succès',
            'data' => $serveurs
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:serveurs',
            'nom' => 'required|string',
        ]);

        $serveur = Serveur::create($validatedData);

        return response()->json([
            'message' => 'Serveur créé avec succès',
            'data' => $serveur
        ], 201);
    }

    public function show($id)
    {
        $serveur = Serveur::findOrFail($id);
        return response()->json([
            'message' => 'Serveur récupéré avec succès',
            'data' => $serveur
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|unique:serveurs,code,' . $id,
            'nom' => 'required|string',
        ]);

        $serveur = Serveur::findOrFail($id);
        $serveur->update($request->all());

        return response()->json([
            'message' => 'Serveur mis à jour avec succès',
            'data' => $serveur
        ], 200);
    }

    public function destroy($id)
    {
        $serveur = Serveur::findOrFail($id);
        $serveur->delete();
        return response()->json([
            'message' => 'Serveur supprimé avec succès'
        ], 200);
    }

    public function destroyAll()
    {
        Serveur::truncate();
        return response()->json([
            'message' => 'Tous les serveurs ont été supprimés'
        ], 200);
    }
}
