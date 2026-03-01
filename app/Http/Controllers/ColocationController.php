<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Support\Str;
use App\Http\Requests\StoreColocationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ColocationController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $ownedColocations = Colocation::where('owner_id', $userId)->get();

        $memberships = Membership::with('colocation')
            ->where('user_id', $userId) 
            ->whereHas('colocation')     
            ->whereNotIn('colocation_id', $ownedColocations->pluck('id'))
            ->whereNull('left_at')
            ->get();

        return view('colocations', compact('ownedColocations', 'memberships'));
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

    public function store(StoreColocationRequest $request)
    {

        return DB::transaction(function () use ($request) {
            
            $colocation = Colocation::create([
                'nom_coloc' => $request->validated('nom_coloc'),
                'owner_id' => Auth::id(),
            ]);

            Membership::create([
                'colocation_id' => $colocation->id,
                'user_id'     => Auth::id(), 
                'role_coloc'    => 'owner',
                'joined_at'     => now(),    
            ]);
            
            return redirect()->route('colocations.index');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $colocation = Colocation::with(['memberships', 'categories'])->findOrFail($id);
        return view('colocation_show', compact('colocation'));
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
        $colocation = Colocation::findOrFail($id);

        if ($colocation->owner_id !== Auth::id()) {
            abort(403, 'Seul le propriétaire peut annuler la colocation.');
        }

        $colocation->update(['status' => 'cancelled']);

        return redirect()->route('colocations.index')
            ->with('success', 'La colocation a été annulée avec succès.');
    }

    public function leave(Colocation $colocation)
    {
        $membership = Membership::where('colocation_id', $colocation->id)
            ->where('user_id', auth()->id())
            ->whereNull('left_at')
            ->firstOrFail();

        $membership->update(['left_at' => now()]);

        // TODO: Gérer ici la logique de réputation (Scénario 3 du projet)
        // Si dette > 0 -> reputation -1, sinon +1

        return redirect()->route('colocations.index')->with('success', 'Vous avez quitté la colocation.');
    }

    public function removeMember(Colocation $colocation, Membership $membership) {
        // Sécurité : seul l'owner peut faire ça
        if (Auth::id() !== $colocation->owner_id) abort(403);

        // TODO: Si le membre a des dettes, les réattribuer à l'owner (règle 5.5)
        // $membership->update(['left_at' => now()]);
        
        return back()->with('success', 'Membre retiré.');
    }
}
