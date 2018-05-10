<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $fillable = ['body','choices','score','quiz_id'];
    protected $casts = [
        'choices' => 'array',
    ];    

    public function quiz(){
      return $this->belongsTo('\App\Quiz');
    }

}
