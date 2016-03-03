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
}
