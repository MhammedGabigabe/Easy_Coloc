<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use App\Models\Invitation;
use Illuminate\Support\Str;
use App\Models\Membership;

class InvitationController extends Controller
{
    public function sendInvitation(Request $request)
    {
        $request->validate([
            'coloc_id' => 'required',
            'email' => 'required|email',
        ]);

        $existing = Invitation::where('email', $request->email)
            ->where('colocation_id', $request->coloc_id)
            ->where('status_inv', 'en_attente')
            ->first();

        if ($existing) {
            return back()->with('error', 'Une invitation est déjà en cours pour cet email.');
        }

        $invitation = Invitation::create([
            'colocation_id' => $request->coloc_id,
            'email' => $request->email, 
            'token_email' => Str::uuid(),
        ]);

        $data = [
            'token_email' => $invitation->token_email,
        ];

        Mail::to($request->email)->send(new InvitationMail($data));

        // return redirect()->route('colocations.show', $request->coloc_id);
        return back()->with('success', 'Invitation envoyée !');
    }
    
    public function showResponsePage($token)
    {
        $invitation = Invitation::where('token_email', $token)->where('status_inv', 'en_attente')->firstOrFail();
        
        $colocation = $invitation->colocation;

        return view('invitation_response', compact('invitation', 'colocation'));
    }

    public function accept( $token)
    {
        $invitation = Invitation::where('token_email', $token)->firstOrFail();
        $user = auth()->user();

        $hasActiveColoc = Membership::where('user_id', $user->id)
            ->whereNull('left_at')
            ->exists();

        if ($hasActiveColoc) {
            return redirect()->route('colocations.index')->with('error', 'Vous avez déjà une colocation active.');
        }

        Membership::create([
            'colocation_id' => $invitation->colocation_id,
            'user_id' => $user->id,
            'role_coloc' => 'member',
            'joined_at' => now(),
        ]);

        $invitation->update(['status_inv' => 'accepte']);

        return redirect()->route('colocations.show', $invitation->colocation_id)
                        ->with('success', 'Bienvenue dans la colocation !');
    }

    public function refuse($token)
    {
        $invitation = Invitation::where('token_email', $token)->firstOrFail();
        $invitation->update(['status_inv' => 'refuse']);

        return redirect()->route('colocations.index')->with('info', 'Invitation refusée.');
    }
}
