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
 * @property $seen2
 * @property $winner_id
 * @property $guesscount
 * @property $degree
 * @property $length
 * @property $today_id
 * @property $isduello
 * @property $chatcode
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
		'word_id' => 'required'
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * @var false|mixed|string
     */


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

    public static function getTodayRanking($todayId, $userId){
        $lists = Game::where('user_id', 2)
            ->where('today_id', $todayId)
            ->where('winner_id', '!=', null)
            ->orderBy('duration', 'asc')
            ->orderBy('guesscount', 'asc')
            ->get();
        $x = 0;
        foreach ($lists as $list) {
            if($list->winner_id != 2){
                $x += 1;
                if($list->opponent_id == $userId){
                    break;
                }
            }
        }
        if($x == 0){
            return "Kazanamdı";
        }
        else{
            return $x.". oldu";
        }
    }
}
