<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Prestataire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avis = Avis::with(['user', 'prestataire'])->get();
        return response()->json($avis);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

    $request->validate([
        'prestataire_id' => 'required|exists:prestataires,id',
        'note' => 'required|integer|min:1|max:5',
        'commentaire' => 'required|string',
    ]);

    $avis = Avis::create([
        'user_id' => Auth::id(),
        'prestataire_id' => $request->prestataire_id, // correct
        'note' => $request->note,
        'commentaire' => $request->commentaire,
    ]);

    // Mise à jour de la note moyenne
    PrestataireController::updateNoteMoyenne($request->prestataire_id);

    return response()->json([
        'message' => 'Avis ajouté avec succès.',
        'data' => $avis,
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $avis = Avis::with(['user', 'prestataire'])->findOrFail($id);
        return response()->json($avis);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $avis = Avis::findOrFail($id);

        if ($avis->user_id !== Auth::id()) {
            return response()->json(['message' => 'Action non autorisée.'], 403);
        }

        $request->validate([
            'note' => 'sometimes|integer|min:1|max:5',
            'commentaire' => 'sometimes|string',
        ]);

        $avis->update($request->only(['note', 'commentaire']));

        // 🧮 Mettre à jour la note moyenne après modification
        PrestataireController::updateNoteMoyenne($avis->prestataire_id);

        return response()->json([
            'message' => 'Avis mis à jour avec succès.',
            'data' => $avis,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $avis = Avis::findOrFail($id);

        if ($avis->user_id !== Auth::id()) {
            return response()->json(['message' => 'Action non autorisée.'], 403);
        }

        $prestataireId = $avis->prestataire_id;
        $avis->delete();

        // 🧮 Met à jour la note moyenne après suppression
        PrestataireController::updateNoteMoyenne($prestataireId);

        return response()->json(['message' => 'Avis supprimé avec succès.']);
    }
}
