<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Invitation extends Model
{
    protected $fillable = [
        'colocation_id', 
        'email', 
        'token_email', 
        'statut_inv',
    ];

    public function colocation() {
        return $this->belongsTo(Colocation::class);
    }
}
