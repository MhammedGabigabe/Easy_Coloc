<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Colocation;
use App\Models\Depense;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_colocs' => Colocation::count(),
            'total_depenses' => Depense::sum('montant'),
            'banned_users' => User::where('is_banned', true)->count(),
        ];

        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin_dashboard', compact('stats', 'users'));
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
    public function store(Request $request)
    {
        //
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

    public function toggleBan(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas vous bannir vous-même.');
        }

        $user->update(['is_banned' => !$user->is_banned]);
        
        $status = $user->is_banned ? 'banni' : 'débanni';
        return back()->with('success', "L'utilisateur {$user->name} a été {$status}.");
    }
}
