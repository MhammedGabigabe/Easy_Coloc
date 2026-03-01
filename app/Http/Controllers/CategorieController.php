<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Colocation;
use Auth;

class CategorieController extends Controller
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
    public function store(Request $request, $id)
    {
        $colocation = Colocation::findOrFail($id);
        if($colocation->owner_id !== Auth::id()){
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'nom_categorie' => 'required|string|max:255',
        ]);

        $categorie = Categorie::firstOrCreate([
            'nom_categorie' => $request->nom_categorie
        ]);

        $colocation->categories()->syncWithoutDetaching([$categorie->id]);
        return back();
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
