<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guess extends Model
{
    use HasFactory;

    public function game()
    {
        return $this->hasOne(Game::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
