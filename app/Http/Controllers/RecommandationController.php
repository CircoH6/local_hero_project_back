<?php

namespace App\Http\Controllers;


use App\Models\Recommandation;
use App\Models\Prestataire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommandationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recommandations = Recommandation::with('prestataire')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($recommandations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prestataire_id' => 'required|exists:prestataires,id',
        ]);

        // Vérifie si l’utilisateur a déjà recommandé ce prestataire
        $dejaRecommande = Recommandation::where('user_id', Auth::id())
            ->where('prestataire_id', $request->prestataire_id)
            ->exists();

        if ($dejaRecommande) {
            return response()->json(['message' => 'Vous avez déjà recommandé cet artisan.'], 400);
        }

        $recommandation = Recommandation::create([
            'user_id' => Auth::id(),
            'prestataire_id' => $request->prestataire_id,
        ]);

        return response()->json([
            'message' => 'Artisan recommandé avec succès.',
            'data' => $recommandation,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $recommandation = Recommandation::findOrFail($id);

        if ($recommandation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Action non autorisée.'], 403);
        }

        $recommandation->delete();

        return response()->json(['message' => 'Recommandation supprimée avec succès.']);
    }
}
