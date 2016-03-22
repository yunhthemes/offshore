<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySecretary extends Model
{
    //
    protected $table = 'company_secretaries';

    protected $fillable = array('name', 'address', 'address_2', 'address_3');

    public function companies()
    {
    	return $this->belongsTo('App\Company', 'company_id');
    }
}
