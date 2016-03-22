<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDirector extends Model
{
    //
    protected $table = 'company_directors';

    protected $fillable = array('name', 'address', 'address_2', 'address_3');

    public function companies()
    {
    	return $this->belongsTo('App\Company', 'company_id');
    }
}
