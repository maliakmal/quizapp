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
        'first_name', 'last_name', 'email', 'password', 'status', 'school', 'grade', 'age', 'gender',
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

    public function school_name()
    {
      return $this->belongsTo('App\School', 'school');
    }

    function scopeWithName($query, $name)
    {
        // Split each Name by Spaces
        $names = explode(" ", $name);

        // Search each Name Field for any specified Name
        return User::where(function($query) use ($names) {
            $query->whereIn('first_name', $names);
            $query->orWhere(function($query) use ($names) {
                $query->whereIn('last_name', $names);
            });
        });
    }
}
