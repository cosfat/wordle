<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Word extends Model
{
    use HasFactory;

    public static function tdk($word)
    {
        $url = "https://sozluk.gov.tr/gts?ara=".$word;

        $json = json_decode(file_get_contents($url), true);

        if(isset($json["error"])){
            return false;
        }
        else{

            return $json[0]['anlamlarListe'][0]['anlam'];
        }
    }
}
