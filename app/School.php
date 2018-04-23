<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public $fillable = ['name','city','country','status'];
  
    public function school_name()
    {
      return $this->belongsTo('App\User');
    }
}
