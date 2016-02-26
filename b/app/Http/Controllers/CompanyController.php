<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;
use App\CompanyType;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    //
    public function index() {
    	$company_types = CompanyType::find(1)->companies;
    	return $company_types;

    }
}
