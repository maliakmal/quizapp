<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public static $fillables = ['title','description','type','state','accessible_from','accessible_to','duration'];
    public $fillable = ['title','description','type','state','accessible_from','accessible_to','duration'];

    public function questions(){
      return $this->hasMany('\App\Question');
    }
    
    function publish(){
      $this->state = 'published';
      $this->save();
    }

    function unpublish(){
      $this->state = 'draft';
      $this->save();
    }

    function isDraft(){
      return $this->state == 'draft' ? true : false;
    }
}
