<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Plat;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function __construct()
    {
     //   $this->middleware('auth:api')->except(['index', 'store']);
    }

    public function index()
    {
        try {
            return Commande::all();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des commandes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            return Commande::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Commande non trouvée',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'table_id' => 'required|exists:tables,id',
                'serveur_id' => 'required|exists:serveurs,id',
                'statut' => 'required|in:en attente,en cours,terminée',
                'plats' => 'required|array',
                'plats.*.id' => 'exists:plats,id',
                'plats.*.quantite' => 'integer|min:1',
            ]);

            // Calculer le total
            $total = 0;
            foreach ($validated['plats'] as $platData) {
                $plat = Plat::findOrFail($platData['id']);
                $total += $plat->prix * $platData['quantite'];
            }

            $commande = Commande::create([
                'table_id' => $request->table_id,
                'serveur_id' => $request->serveur_id,
                'statut' => $request->statut,
                'plats' => $request->plats,
                'total' => $total, // Ajout du total calculé
            ]);

            return response()->json($commande, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de la commande',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                // 'table_id' => 'required|exists:tables,id',
                // 'serveur_id' => 'required|exists:serveurs,id',
                // 'statut' => 'required|in:en attente,en cours,terminée',
                'plats' => 'sometimes|array',
                'plats.*.id' => 'exists:plats,id',
                'plats.*.quantite' => 'integer|min:1',
            ]);

            $commande = Commande::findOrFail($id);

            // Recalculer le total si les plats sont fournis
            if (isset($validated['plats'])) {
                $total = 0;
                foreach ($validated['plats'] as $platData) {
                    $plat = Plat::findOrFail($platData['id']);
                    $total += $plat->prix * $platData['quantite'];
                }
                $validated['total'] = $total;
            }

            $commande->update($validated);
            return response()->json($commande);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de la commande',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $commande = Commande::findOrFail($id);
            $commande->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression de la commande',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function statistiques()
    {
        try {
            $enAttente = Commande::where('statut', 'en attente')->count();
            $enCours = Commande::where('statut', 'en cours')->count();
            $terminees = Commande::where('statut', 'terminée')->count();

            return response()->json([
                'en_attente' => $enAttente,
                'en_cours' => $enCours,
                'terminees' => $terminees,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des statistiques',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function ajouterPlat(Request $request, $commandeId)
    {
        try {
            $request->validate([
                'plat_id' => 'required|exists:plats,id',
                'quantite' => 'required|integer|min:1',
            ]);

            $commande = Commande::findOrFail($commandeId);
            $plats = $commande->plats ?? [];
            $plats[] = [
                'id' => $request->plat_id,
                'quantite' => $request->quantite,
            ];

            // Recalculer le total
            $total = 0;
            foreach ($plats as $platData) {
                $plat = Plat::findOrFail($platData['id']);
                $total += $plat->prix * $platData['quantite'];
            }

            $commande->update([
                'plats' => $plats,
                'total' => $total,
            ]);

            return response()->json(['message' => 'Plat ajouté à la commande'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de l’ajout du plat',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
