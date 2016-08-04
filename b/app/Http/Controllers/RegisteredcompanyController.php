<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Company;
use App\CompanyWpuser;
use App\Service;
use App\Country;

class RegisteredcompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$companies = Company::with(['wpusers' => function($query) {
            $query->wherePivot('status', 1); }, 'companytypes'])->where('status', 1)->get();   

    	return view('registeredcompany.index', ['companies'=>$companies]);
    }

    public function show(Request $request, $id) {

        $company = Company::with(['wpusers' => function($query) {
            $query->wherePivot('status', 1); }])->where("id", $id)->where('status', 1)->first();

        $companywpuser_id = $company->wpusers[0]->pivot->id;

        $company = Company::with(['wpusers' => function($query) {
            $query->wherePivot('status', 1); }, 'companytypes', 'companywpuser_shareholders' => function($query) use($companywpuser_id){
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_directors' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_secretaries' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_servicecountries' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_informationservices' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }])->where("id", $id)->where('status', 1)->first();

        // return $company;

        $companywpuser_informationservices = CompanyWpuser::with(['informationservices'])->where('company_id', $company->id)->where('id', $companywpuser_id)->first();

        $informationservices = $companywpuser_informationservices->informationservices;

        $companywpuser_servicescountries = CompanyWpuser::with(['servicescountries'])->where('company_id', $company->id)->where('id', $companywpuser_id)->first();

        $servicescountries = $companywpuser_servicescountries->servicescountries;      
        
        foreach ($servicescountries as $key => $value) {
            $service = Service::where('id',$value->service_id)->first();
            $country = Country::where('id', $value->country_id)->first();

            $value->service_name = $service->name;
            $value->country_name = $country->name;            
        }       

        // return $servicescountries;

        return view('registeredcompany.show', ['company'=>$company, 'informationservices'=>$informationservices, 'servicescountries'=>$servicescountries]);
    }

}
