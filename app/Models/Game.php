<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 *
 * @property $id
 * @property $user_id
 * @property $opponent_id
 * @property $word
 * @property $word_1
 * @property $word_2
 * @property $word_3
 * @property $word_4
 * @property $word_5
 * @property $word_6
 * @property $seen
 * @property $winner_id
 * @property $degree
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
		'word' => 'required',
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
