<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colocation;
use Illuminate\Support\Str;
use App\Http\Requests\StoreColocationRequest;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colocations = Colocation::where('owner_id', auth()->id())
                ->latest()
                ->paginate(3);
        return view('colocations', compact('colocations'));
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

        Colocation::create([
            'nom_coloc' => $request->validated('nom_coloc'),
            'owner_id' => Auth::id(),
        ]);
        return redirect()->route('colocations.index');
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
}
