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

        $wpuser_compaines = Company::with("companytypes")->where('wpuser_id', $id)->get();        

        foreach ($wpuser_compaines as $key => $wpuser_company) {
            $wpuser_company->incorporation_date = date('d M Y', strtotime($wpuser_company->incorporation_date));
            $wpuser_company->renewal_date = date('d M Y', strtotime($wpuser_company->renewal_date));
        }

    	if(empty($wpuser_compaines)) {		
    		return response()->json(['message' => 'user not found'], 202)->setCallback($request->input('callback'));
    	}
        
        return response()->json(['message' => 'Success', 'companies' => $wpuser_compaines], 200)->setCallback($request->input('callback'));

    }

    public function usercompanydetails($id, Request $request) {

        $wpuser_company_details = Company::with('companytypes','companyshareholders', 'companydirectors', 'companysecretaries', 'servicescountries', 'informationservice')->get()->find($id);

        $wpuser_company_details->renewal_date = date('d M Y', strtotime($wpuser_company_details->renewal_date));
        $wpuser_company_details->incorporation_date = date('d M Y', strtotime($wpuser_company_details->incorporation_date));

        if(!$wpuser_company_details) {
            return response()->json(['message' => 'company not found'], 202)->setCallback($request->input('callback'));
        }

        return response()->json(['message' => 'Success', 'companydetails' => $wpuser_company_details], 200)->setCallback($request->input('callback'));

    }

    public function uploadfiles(Request $request) {

        // $type = $request->type;

        if ($request->hasFile('files')) {
            $file = $request->file('files');   
            $destinationPath = public_path() . "/uploads/";

            $orgFilename     = $file->getClientOriginalName();
            $filename        = str_random(6) . '_' . $file->getClientOriginalName();
            $uploadSuccess   = $file->move($destinationPath, $filename);
        }

        if(!empty($uploadSuccess)) {
            error_log("Destination: $destinationPath");
            error_log("Filename: $filename");
            error_log("Extension: ".$file->getClientOriginalExtension());
            error_log("Original name: ".$file->getClientOriginalName());
            error_log("Real path: ".$file->getRealPath());
            return response()->json([
                "file" => [
                    "name" => $filename,
                    "org_name" => $orgFilename,
                    "destinationPath" => $destinationPath              
                ]
            ]);

            // return $filename . '||' . $orgFilename . '||' . $destinationPath;
        }
        else {
            error_log("Error moving file: ".$file->getClientOriginalName());
            return 'Erorr on ';
        }          

    }
}
