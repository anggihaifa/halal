<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'sys_log';

    protected $guarded = [
        'id'
    ];
}
