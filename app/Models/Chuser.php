<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chuser extends Model
{
    use HasFactory;

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function chguesses()
    {
        return $this->hasMany(Chguess::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
