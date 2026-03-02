<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'memberships';

    protected $fillable = [
        'colocation_id', 
        'user_id', 
        'role_coloc', 
        'left_at', 
        'joined_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    } 
    
    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }

    public function dettes()
    {
        return $this->hasMany(Dette::class);
    }
}
