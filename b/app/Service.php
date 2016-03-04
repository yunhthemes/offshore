<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $table = 'services';

    public function companytypes()
    {
        return $this->belongsToMany('App\CompanyType', 'companytype_service')->withPivot('price');
    }

    public function companies()
    {
        return $this->belongsToMany('App\Company', 'company_service');
    }
}
