<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    //
    protected $table = 'company_types';

    public function companies()
    {
        return $this->hasMany('App\Company');
    }
}
