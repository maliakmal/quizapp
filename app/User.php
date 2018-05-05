<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'status', 'type', 'school_id', 'grade', 'age', 'gender',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getFullNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }
    public function getGravatarAttribute(){
        return 'https://www.gravatar.com/avatar/'.md5($this->email);
    }

    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles)
    {

        if (is_array($roles)) {

            return $this->hasAnyRole($roles) || 
                    abort(401, 'This action is unauthorized.');

        }

        return $this->hasRole($roles) || 
                abort(401, 'This action is unauthorized.');

    }

    /**
    * Check multiple roles
    * @param array $roles
    */

    public function hasRoles($roles){
        if(!is_array($roles)){
            $roles = [$roles];
        }

        return $this->hasAnyRole($roles);
    }
    public function hasAnyRole($roles)
    {

        return null !== $this->roles()->whereIn('name', $roles)->first();

    }

    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {

        return null !== $this->roles()->where('name', $role)->first();

    }

    public function getSchoolnameAttrbute(){
        return !is_null($this->school) ? $this->school->name:'Unknown';
    }

    public function school_name_a()
    {
      return $this->belongsTo('App\School', 'school');
    }

    public function school()
    {
      return $this->belongsTo('App\School');
    }

    public function scopeByRoles($query, $roles){
        $roles = !is_array($roles)?[$roles]:$roles;
        $role_ids = \App\Role::whereIn('name', $roles)->get()->pluck('id','id');

        return $query->join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->whereIn('role_user.role_id', $role_ids);
    }

    public function scopeBySchool($query, $school_id){

        return $query->where('school_id', '=', $school_id);
    }

    public function scopeBySchools($query, $school_ids){

        return $query->whereIn('school_id', $school_ids);
    }

    public function scopeByCountry($query, $country){
        $school_ids = School::where('country', '=', $country)->get()->pluck('id', 'id')->all();
        return $this->bySchools($school_ids);
    }

    function scopeWithName($query, $name)
    {
        // Split each Name by Spaces
        $names = explode(" ", $name);
        $sql = [];
        foreach($names as $name){
        }

        // Search each Name Field for any specified Name
        return User::where(function($query) use ($names) {
            $query->whereIn('first_name', $names);
            $query->orWhere(function($query) use ($names) {
                $query->whereIn('last_name', $names);
            });
        });
    }
}
