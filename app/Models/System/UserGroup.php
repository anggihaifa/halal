<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'usergroup';

    protected $guarded = [
        'id'
    ];
}
