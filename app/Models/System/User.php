<?php

namespace App\Models\System;

use App\Models\Master\Bumn;
use App\Models\Registrasi;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Notifiable;

    protected $table = 'users';

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'password','remember_token',
    ];

    public function registrasi(){
        return $this->hasOne(
            Registrasi::class,
            'id',
            'registrasi_id',
        );
    }

    public function usergroup(){
        return $this->hasOne(
            UserGroup::class,
            'id',
            'usergroup_id'
        );
    }

    public function hasRole($role){

        return User::where('role', $role)->get();
    }
    
}
