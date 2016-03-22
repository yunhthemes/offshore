<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCountry extends Model
{
    //
    protected $table = 'service_country';

    public function companies()
    {
        return $this->belongsToMany('App\Company', 'company_service_country');
    }
}
