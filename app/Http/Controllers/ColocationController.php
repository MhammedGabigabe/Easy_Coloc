<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Membership;
use App\Models\Dette;
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
            $colocationExiste = Colocation::where('owner_id', Auth::id())->where('status', 'active')->first();
            
            if($colocationExiste != null){
                    return redirect()
                        ->route('colocations.index')
                        ->with('error', 'Vous avez déjà une colocation active.');
            }else{

            
                DB::transaction(function () use ($request) {
            
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
            });

            return redirect()->route('colocations.index')->with('success', 'Colocation créée avec succès');
    }}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $colocation = Colocation::with([
            'memberships' => function($q) {
                $q->whereNull('left_at');
            },
            'memberships.user',
            'categories',
            'depenses.payeur',
        ])->findOrFail($id);

        $userId = auth()->id();

        $mesDettes = Dette::whereHas('membership', function($q) use ($id, $userId) {
                $q->where('colocation_id', $id)->where('user_id', $userId);
            })
            ->where('statut_dette', false)
            ->with('depense.payeur')
            ->get();

        $dettesQuOnMeDoit = Dette::whereHas('depense', function($q) use ($id, $userId) {
                $q->where('colocation_id', $id)->where('createur_id', $userId);
            })
            ->where('statut_dette', false)
            ->with('membership.user')
            ->get();    

        return view('colocation_show', compact('colocation', 'mesDettes', 'dettesQuOnMeDoit'));
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
            abort(403, 'Seul le owner peut annuler la colocation.');
        }

        $colocation->update(['status' => 'cancelled']);
        $colocation->update(['deleted_ar' => now()]);

        return redirect()->route('colocations.index')
            ->with('success', 'La colocation a été annulée avec succès.');
    }

    public function leave($colocationId)
    {
        $userId = auth()->id();
        $colocation = Colocation::findOrFail($colocationId);

        $membership = Membership::where('colocation_id', $colocationId)
            ->where('user_id', $userId)
            ->whereNull('left_at')
            ->firstOrFail();

        $dettesImpaye = Dette::where('membership_id', $membership->id)
            ->where('statut_dette', false)
            ->exists();

        if ($dettesImpaye) {
            auth()->user()->decrement('reputation');

            $this->transferDebtsToOwner($colocation, $membership);
            $message = "Vous avez quitté la coloc en règle (-1 rép).";
        } else {
            auth()->user()->increment('reputation');
            $message = "Vous avez quitté la coloc en règle (+1 rép).";
        }

        $membership->update(['left_at' => now()]);

        return redirect()->route('colocations.index')->with('success', $message);
    }

    public function removeMember($colocationId, $membershipId)
    {
        $colocation = Colocation::findOrFail($colocationId);
        if (auth()->id() !== $colocation->owner_id) abort(403);

        $membership = Membership::findOrFail($membershipId);
        $user = $membership->user;

        $dettesImpaye = Dette::where('membership_id', $membership->id)
            ->where('statut_dette', false)
            ->exists();

        if ($dettesImpaye) {
            $this->transferDebtsToOwner($colocation, $membership);
            $msg = "Membre retiré. Ses dettes vous ont été imputées.";
        } else {
            $user->increment('reputation');
            $msg = "Membre retiré.";
        }

        $membership->update(['left_at' => now()]);

        return back()->with('success', $msg);
    }

    private function transferDebtsToOwner(Colocation $colocation, Membership $memberMembership)
    {
        $ownerMembership = Membership::where('colocation_id', $colocation->id)
            ->where('user_id', $colocation->owner_id)
            ->first();

        if ($ownerMembership) {
            Dette::where('membership_id', $memberMembership->id)
                ->where('statut_dette', false)
                ->update(['membership_id' => $ownerMembership->id]);
        }
    }
}
