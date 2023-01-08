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
		'seen' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','opponent_id','word','word_1','word_2','word_3','word_4','word_5','word_6','seen','winner_id','degree'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function word(){
        return $this->belongsTo(Word::class);
    }
}
