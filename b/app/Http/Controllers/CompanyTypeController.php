<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;
use App\CompanyType;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompanyTypeController extends Controller
{
    //
    public function index($id) {
    	
    		$company_types = CompanyType::find($id);

    		if($company_types) {
    			$company_types->companies;
    			return $company_types;
    		}else
    			return response()->json(['message' => 'no resource was found'], 404);
    		

    }
}
