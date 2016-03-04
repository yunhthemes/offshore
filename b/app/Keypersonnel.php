<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keypersonnel extends Model
{
    //
    protected $table = 'keypersonnel';

    public function companies()
    {
        return $this->belongsToMany('App\CompanyType', 'company_keypersonnel')->withPivot('share_amount');
    }
}
