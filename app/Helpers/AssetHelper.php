<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AssetHelper{

    public static function authz_model(Model $model, string $field){
        if(Auth::user()->usergroup_id == 1) return true;

        return $model->{$field} == Auth::user()->id;
    }

}

