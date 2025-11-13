<?php

namespace App\Http\Controllers;

use App\Models\Prestataire;
use App\Models\Avis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestataireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestataires = Prestataire::with('user', 'avis')->get();
        return response()->json($prestataires);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
        ]);

        $prestataire = Prestataire::create([
            'user_id' => Auth::id(),
            'nom' => $request->nom,
            'adresse' => $request->adresse,
            'localisation' => $request->localisation,
            'telephone' => $request->telephone,
        ]);

        return response()->json([
            'message' => 'Prestataire ajouté avec succès.',
            'data' => $prestataire,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prestataire = Prestataire::with('avis.user')->findOrFail($id);
        return response()->json($prestataire);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $prestataire = Prestataire::findOrFail($id);

        // Seul le user qui a ajouté le prestataire peut le modifier
        if ($prestataire->user_id !== Auth::id()) {
            return response()->json(['message' => 'Action non autorisée.'], 403);
        }

        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'adresse' => 'sometimes|string|max:255',
            'localisation' => 'sometimes|string|max:255',
            'telephone' => 'sometimes|string|max:20',
        ]);

        $prestataire->update($request->only(['nom', 'adresse', 'localisation', 'telephone']));

        return response()->json([
            'message' => 'Prestataire mis à jour avec succès.',
            'data' => $prestataire,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prestataire = Prestataire::findOrFail($id);

        if ($prestataire->user_id !== Auth::id()) {
            return response()->json(['message' => 'Action non autorisée.'], 403);
        }

        $prestataire->delete();

        return response()->json(['message' => 'Prestataire supprimé avec succès.']);
    }

    public static function updateNoteMoyenne($prestataire_id)
    {
        $moyenne = Avis::where('prestataire_id', $prestataire_id)->avg('note');
        Prestataire::where('id', $prestataire_id)->update(['note_moyenne' => $moyenne]);
    }
}
