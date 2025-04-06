<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlatController extends Controller
{
    public function index()
    {
        $plats = Plat::all();
        return response()->json([
            'message' => 'Liste des plats récupérée avec succès',
            'data' => $plats
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prix' => 'required|numeric',
            'categorie_id' => 'required|exists:categorie_plats,id',
            'photo' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('plats', 'public');
            $data['photo'] = $path;
        }

        $plat = Plat::create($data);
        return response()->json([
            'message' => 'Plat créé avec succès',
            'data' => $plat
        ], 201);
    }

    public function show($id)
    {
        $plat = Plat::findOrFail($id);
        return response()->json([
            'message' => 'Plat récupéré avec succès',
            'data' => $plat
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string',
            'prix' => 'required|numeric',
            'categorie_id' => 'required|exists:categorie_plats,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        $plat = Plat::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($plat->photo) {
                Storage::disk('public')->delete($plat->photo);
            }
            $path = $request->file('photo')->store('plats', 'public');
            $data['photo'] = $path;
        }

        $plat->update($data);
        return response()->json([
            'message' => 'Plat mis à jour avec succès',
            'data' => $plat
        ], 200);
    }

    public function destroy($id)
    {
        $plat = Plat::findOrFail($id);
        if ($plat->photo) {
            Storage::disk('public')->delete($plat->photo);
        }
        $plat->delete();
        return response()->json([
            'message' => 'Plat supprimé avec succès'
        ], 200);
    }
}
