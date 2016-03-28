<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;
use App\CompanyType;
use App\Wpuser;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //
    public function companytype($id) {
    	
		$company_types = CompanyType::find($id);

		if($company_types) {
			$company_types->companies;
			return $company_types;
		}else
			return response()->json(['message' => 'no resource was found'], 404);
    		
    }

    public function usercompanies($id, Request $request) {

    	$wpuser = Wpuser::with('companytypes')->find($id);
    	if($wpuser) {
    		$wpuser_compaines = $wpuser->companies;            	
    	}else {
    		return response()->json(['message' => 'user not found'], 202)->setCallback($request->input('callback'));
    	}
        
        return response()->json(['message' => 'Success', 'companies' => $wpuser_compaines], 200)->setCallback($request->input('callback'));

    }

    public function usercompanydetails($id, Request $request) {

        $wpuser_company_details = Company::with('companytypes','companyshareholders', 'companydirectors', 'companysecretaries', 'servicescountries', 'informationservice')->get()->find($id);

        if(!$wpuser_company_details) {
            return response()->json(['message' => 'company not found'], 202)->setCallback($request->input('callback'));
        }

        return response()->json(['message' => 'Success', 'companydetails' => $wpuser_company_details], 200)->setCallback($request->input('callback'));

    }
}
