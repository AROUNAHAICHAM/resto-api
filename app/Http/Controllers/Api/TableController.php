<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return response()->json([
            'message' => 'Liste des tables récupérée avec succès',
            'data' => $tables
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|integer|unique:tables',
        ]);

        $table = Table::create($request->all());
        return response()->json([
            'message' => 'Table créée avec succès',
            'data' => $table
        ], 201);
    }

    public function show($id)
    {
        $table = Table::findOrFail($id);
        return response()->json([
            'message' => 'Table récupérée avec succès',
            'data' => $table
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero' => 'required|integer|unique:tables,numero,' . $id,
        ]);

        $table = Table::findOrFail($id);
        $table->update($request->all());
        return response()->json([
            'message' => 'Table mise à jour avec succès',
            'data' => $table
        ], 200);
    }

    public function destroy($id)
    {
        $table = Table::find($id);
        if (!$table) {
            return response()->json(['message' => 'Table non trouvée'], 404);
        }
        $table->delete();
        return response()->json([
            'message' => 'Table supprimée avec succès'
        ], 200);
    }

    public function destroyAll()
    {
        Table::truncate();
        return response()->json([
            'message' => 'Toutes les tables ont été supprimées avec succès'
        ], 200);
    }
}
