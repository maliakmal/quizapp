<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public static $fillables = ['title','description','type','state', 'total_score', 'accessible_from','accessible_to','duration'];
    public $fillable = ['title','description','type','state', 'total_score','accessible_from','accessible_to','duration'];

    public function questions(){
      return $this->hasMany('\App\Question');
    }

    public function submissions(){
      return $this->hasMany('\App\Submission');
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

    function resetTotalScore(){
      $this->total_score = $this->questions()->sum('score');
    }

    function scopeForToday($query){
      return $query->whereDate('accessible_from',  \DB::raw('CURDATE()'))->whereDate('accessible_to',  \DB::raw('CURDATE()'));
    }

    function scopeForCategory($query, $category){
      return $query->where('type', '=', $category);
    }

    function isCompletedByUser($user_id){
      $existingSubmissions = $this->submissions()
                              ->where('submissions.user_id', '=', $user_id)
                              ->get()->count();
      return $existingSubmissions > 0 ? true : false;
    }
}
