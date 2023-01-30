<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    public function chguesses()
    {
        return $this->hasMany(Chguess::class);
    }

    public function chusers()
    {
        return $this->hasMany(Chuser::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}