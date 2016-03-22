<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyShareholder extends Model
{
    //
    protected $table = 'company_shareholders';

    protected $fillable = array('name', 'address', 'address_2', 'address_3', 'share_amount');

    public function companies()
    {
    	return $this->belongsTo('App\Company', 'company_id');
    }
}
