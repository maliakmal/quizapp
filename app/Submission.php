<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{

  public static $fillables = ['answers','score','total_score','duration','start_at','end_at','user_id','quiz_id'];
  public $fillable = ['answers','score','total_score','duration','start_at','end_at','user_id','quiz_id'];

  public function quiz(){
    return $this->belongsTo('\App\Quiz');
  }

  public function user(){
    return $this->belongsTo('\App\User');
  }

    
}
