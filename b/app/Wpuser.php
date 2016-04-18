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
    	// return $this->hasMany('App\Company');
        return $this->belongsToMany('App\Company', 'company_wpusers');
    }

    public function companywpuser_shareholders()
    {
        return $this->hasManyThrough(
          'App\CompanyWpuserShareholder', 'App\CompanyWpuser', 'wpuser_id', 'companywpuser_id'
        );
    }

    
}
