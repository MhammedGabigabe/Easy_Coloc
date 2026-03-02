<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Depense;
use DB;
use Auth;
use App\Models\Membership;
use App\Models\Dette;

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

            return DB::transaction(function () use ($request, $colocation) {
                
                $depense = Depense::create([
                    'titre' => $request->titre,
                    'montant' => $request->montant,
                    'createur_id' => Auth::id(),
                    'colocation_id' => $colocation->id,
                    'categorie_id' => $request->categorie_id,
                    'date_depense' => $request->date_depense,
                ]);

                $membres = Membership::where('colocation_id', $colocation->id)
                                    ->whereNull('left_at')
                                    ->get();

                $nombreDeMembres = $membres->count();
                
                if ($nombreDeMembres > 1) {
                    $partIndividuelle = $request->montant / $nombreDeMembres;

                    foreach ($membres as $membership) {
                        if ($membership->user_id !== Auth::id()) {
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

    public function payerDette($detteId)
    {
        $dette = Dette::findOrFail($detteId);
        
        $dette->update([
            'statut_dette' => true,
            'date_paiement' => now()
        ]);

        return back()->with('success', 'Remboursement enregistré !');
    }
}
