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

        $memberships = Membership::where('user_id', $userId)
            ->whereNotIn('colocation_id', $ownedColocations->pluck('id'))
            ->whereNull('left_at')
            ->with('colocation')
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
        $colocation = Colocation::findOrFail($id);
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
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        $colocation->delete();

        return redirect()->route('colocations.index');
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
}
