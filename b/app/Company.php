<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $table = 'companies';

    public function companytypes()
    {
        return $this->belongsTo('App\CompanyType', 'company_type_id');
    }

 	public function services()
    {
        return $this->belongsToMany('App\Service', 'company_service');
    }
}
