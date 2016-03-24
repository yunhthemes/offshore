<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wpuser extends Model
{
    //
    protected $primaryKey = 'ID';
    protected $table = 'wp_users';

    public function companies()
    {
        return $this->hasMany('App\Company');
    }

    
}
