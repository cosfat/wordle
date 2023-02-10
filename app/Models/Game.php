<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 *
 * @property $id
 * @property $user_id
 * @property $opponent_id
 * @property $word_id
 * @property $seen
 * @property $winner_id
 * @property $guesscount
 * @property $degree
 * @property $length
 * @property $today_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Game extends Model
{

    static $rules = [
		'user_id' => 'required',
		'opponent_id' => 'required',
		'word_id' => 'required',
		'seen' => '',
		'seen2' => '',
		'smiley' => '',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','opponent_id','word','seen','winner_id','degree', 'seen2', 'smiley'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function word(){
        return $this->belongsTo(Word::class);
    }

    public function guesses()
    {
        return $this->hasMany(Guess::class);
    }

    public function opponent(){
        return $this->belongsTo(Opponent::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
