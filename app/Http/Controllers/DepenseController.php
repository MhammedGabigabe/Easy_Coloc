<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $colocationId)
        {
            $request->validate([
                'titre' => 'required|string|max:255',
                'montant' => 'required|numeric|min:0.01',
                'categorie_id' => 'required|exists:categories,id',
                'date_depense' => 'required|date',
            ]);

            $colocation = Colocation::findOrFail($colocationId);

            // Début de la transaction pour garantir que tout est créé proprement
            return DB::transaction(function () use ($request, $colocation) {
                
                // 1. Créer la dépense
                $depense = Depense::create([
                    'titre' => $request->titre,
                    'montant' => $request->montant,
                    'createur_id' => Auth::id(), // Le payeur
                    'colocation_id' => $colocation->id,
                    'categorie_id' => $request->categorie_id,
                    'date_depense' => $request->date_depense,
                ]);

                // 2. Récupérer tous les membres ACTIFS de la coloc
                $membres = Membership::where('colocation_id', $colocation->id)
                                    ->whereNull('left_at')
                                    ->get();

                $nombreDeMembres = $membres->count();
                
                if ($nombreDeMembres > 1) {
                    // 3. Calculer la part de chacun
                    $partIndividuelle = $request->montant / $nombreDeMembres;

                    foreach ($membres as $membership) {
                        // On crée une dette UNIQUEMENT pour les membres qui n'ont pas payé
                        if ($membership->membre_id !== Auth::id()) {
                            Dette::create([
                                'membership_id' => $membership->id,
                                'depense_id' => $depense->id,
                                'montant_a_payer' => $partIndividuelle,
                                'statut_dette' => false,
                            ]);
                        }
                    }
                }

                return back()->with('success', 'Dépense enregistrée et divisée entre les membres !');
            });
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
        //
    }
}
