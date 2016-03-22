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

    public function companydirectors()
    {
    	return $this->hasMany('App\CompanyDirector');
    }

    public function companyshareholders()
    {
    	return $this->hasMany('App\CompanyShareholder');
    }

    public function companysecretaries()
    {
    	return $this->hasMany('App\CompanySecretary');
    }

    public function servicescountries()
    {
        return $this->belongsToMany('App\ServiceCountry', 'company_service_country');
    }
}
