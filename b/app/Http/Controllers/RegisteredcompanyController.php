<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Company;
use App\CompanyWpuser;
use App\Service;
use App\Country;
use App\CompanyWpuserDirector;
use App\CompanyWpuserShareholder;
use App\CompanyWpuserSecretary;
use App\CompanyWpuserNominee;
use App\Wpuser;
use App\Person;

class RegisteredcompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        

    	$companies = Company::with(['wpusers', 'companytypes'])->where('status', 1)->orWhere('code', 'Rejected')->get();

    	return view('registeredcompany.index', ['companies'=>$companies]);
    }

    public function show(Request $request, $id) {

        $company = Company::with(['wpusers'])->where("id", $id)->first(); //->where('status', 1)->orWhere('code', 'Rejected')

        $companywpuser_id = $company->wpusers[0]->pivot->id;

        $company = Company::with(['wpusers', 'companytypes', 'companywpuser_shareholders' => function($query) use($companywpuser_id){
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_directors' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_secretaries' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_servicecountries' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_informationservices' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }])->where("id", $id)->first(); //->where('status', 1)->orWhere('code', 'Rejected')

        //////
        // nominees
        //////

        $companywpuser_nominee_shareholder = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'shareholder')->first();
        $companywpuser_nominee_director = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'director')->first();
        $companywpuser_nominee_secretary = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'secretary')->first();

        ///////

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

        $companywpuser = CompanyWpuser::where('company_id', $company->id)->where('id', $companywpuser_id)->first();

        // return $servicescountries;

        return view('registeredcompany.show', ['company'=>$company, 'informationservices'=>$informationservices, 'servicescountries'=>$servicescountries, 'companywpuser_nominee_shareholder'=>$companywpuser_nominee_shareholder, 'companywpuser_nominee_director'=>$companywpuser_nominee_director, 'companywpuser_nominee_secretary'=> $companywpuser_nominee_secretary, 'companywpuser' => $companywpuser]);
    }

    public function edit(Request $request, $id) {

        // => function($query) {
            // $query->wherePivot('status', 1); }

        $company = Company::with(['wpusers'])->where("id", $id)->first(); //->where('status', 1)->orWhere('code', 'Rejected')

        if(count($company->wpusers) > 0) {
            $companywpuser_id = $company->wpusers[0]->pivot->id;
        }

        // return $company;

        $company = Company::with(['wpusers', 'companytypes', 
            'companywpuser_shareholders' => function($query) use($companywpuser_id){
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_directors' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_secretaries' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_servicecountries' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }, 'companywpuser_informationservices' => function($query) use($companywpuser_id) {
                $query->where('companywpuser_id', $companywpuser_id);
            }])->where("id", $id)->first(); //->where('status', 1)->orWhere('code', 'Rejected')

        // return $company;

        //////
        // nominees
        //////

        $companywpuser_nominee_shareholder = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'shareholder')->first();
        $companywpuser_nominee_director = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'director')->first();
        $companywpuser_nominee_secretary = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'secretary')->first();

        ///////

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

        $companywpuser = CompanyWpuser::where('company_id', $company->id)->where('id', $companywpuser_id)->first();

        $person = Person::select('person_code', 'first_name')->get();

        $countryList = Country::lists('name', 'name')->all();

        return view('registeredcompany.edit', ['company'=>$company, 'informationservices'=>$informationservices, 'servicescountries'=>$servicescountries, 'companywpuser_nominee_shareholder'=>$companywpuser_nominee_shareholder, 'companywpuser_nominee_director'=>$companywpuser_nominee_director, 'companywpuser_nominee_secretary'=> $companywpuser_nominee_secretary, 'companywpuser' => $companywpuser, 'person' => $person, 'countryList' => $countryList ]);
    }

    public function update(Request $request, $id) {     

        if($request->submit=="Approve") {
            $status = 2;
        }
        elseif($request->submit=="Reject") {
            $status = 3;
        }
        else {
            $status = 1;
        }        
        
        $company = Company::with(['wpusers'])->where('id', $id)->first();
                
        $companywpuser_id = $company->wpusers[0]->pivot->id;

        $companywpuser = CompanyWpuser::find($companywpuser_id);

        ////
        //// updating company related fields
        ////

        $companywpuser->reg_no = $request->reg_no;
        $companywpuser->tax_no = $request->tax_no;
        $companywpuser->vat_reg_no = $request->vat_reg_no;        
        $companywpuser->reg_office = $request->reg_office;
        $companywpuser->status = $status;

        ////
        //// updating date fields
        //// 
        
        $companywpuser->date_of_next_accounts = date_create_from_format('d/m/y', $request->date_of_next_accounts);
        $companywpuser->date_of_last_accounts = date_create_from_format('d/m/y', $request->date_of_last_accounts);
        $companywpuser->next_domiciliation_renewal = date_create_from_format('d/m/y', $request->next_domiciliation_renewal);
        $companywpuser->accounts_completion_deadline = date_create_from_format('d/m/y', $request->accounts_completion_deadline);
        $companywpuser->date_of_last_vat_return = date_create_from_format('d/m/y', $request->date_of_last_vat_return);
        $companywpuser->date_of_next_vat_return = date_create_from_format('d/m/y', $request->date_of_next_vat_return);
        $companywpuser->vat_return_deadline = date_create_from_format('d/m/y', $request->vat_return_deadline);
        $companywpuser->next_agm_due_by = date_create_from_format('d/m/y', $request->next_agm_due_by);
        

        ////
        //// updating pdf upload fields
        ////

        $companywpuser->incorporation_certificate = $request->incorporation_certificate;
        $companywpuser->incumbency_certificate = $request->incumbency_certificate;
        $companywpuser->company_extract = $request->company_extract;
        $companywpuser->last_financial_statements = $request->last_financial_statements;
        $companywpuser->other_documents_1 = $request->other_documents_1;
        $companywpuser->other_documents_2 = $request->other_documents_2;
        $companywpuser->other_documents_3 = $request->other_documents_3;
        $companywpuser->other_documents_4 = $request->other_documents_4;
        $companywpuser->other_documents_5 = $request->other_documents_5;
        $companywpuser->other_documents_6 = $request->other_documents_6;
        $companywpuser->other_documents_1_title = $request->other_documents_1_title;
        $companywpuser->other_documents_2_title = $request->other_documents_2_title;
        $companywpuser->other_documents_3_title = $request->other_documents_3_title;
        $companywpuser->other_documents_4_title = $request->other_documents_4_title;
        $companywpuser->other_documents_5_title = $request->other_documents_5_title;
        $companywpuser->other_documents_6_title = $request->other_documents_6_title;

        ////
        //// updating nominee director/secretary fields
        ////

        $companywpuser->nominee_director_person_code = $request->nominee_director_person_code;
        $companywpuser->nominee_secretary_person_code = $request->nominee_secretary_person_code;

        $companywpuser->save(); 

        // update company    

        $company = Company::find($id);
        $company->name = $request->input('company_name');
        if($request->submit=="Approve") {
            $company->code = $request->input('company_code');
        }elseif($request->submit=="Reject") {
            $company->code = "Rejected";
        }else {
            $company->code = "New Inc";
        }
        
        $company->incorporation_date = $request->input('incorporation_date');
        if($request->submit=="Approve") {
            $company->status = 1; // approved
        }
        if($request->submit=="Reject") {
            $company->status = 0; // rejected
        }
        $company->save();   

        // $companywpuser_nominee_shareholder = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'shareholder')->first();

        // if(empty($companywpuser_nominee_shareholder)) {
        //     $companywpuser_nominee_shareholder = new CompanyWpuserNominee;
        // }

        // if(!empty($request->input('nominee_shareholder_name')) && !empty($request->input('nominee_shareholder_address')) && !empty($request->input('nominee_shareholder_telephone')) ) {
        //     $companywpuser_nominee_shareholder->companywpuser_id = $companywpuser_id;
        //     $companywpuser_nominee_shareholder->name = $request->input('nominee_shareholder_name');
        //     $companywpuser_nominee_shareholder->address = $request->input('nominee_shareholder_address');
        //     $companywpuser_nominee_shareholder->address_2 = $request->input('nominee_shareholder_address_2');
        //     $companywpuser_nominee_shareholder->address_3 = $request->input('nominee_shareholder_address_3');
        //     $companywpuser_nominee_shareholder->address_4 = $request->input('nominee_shareholder_address_4');
        //     $companywpuser_nominee_shareholder->telephone = $request->input('nominee_shareholder_telephone');
        //     $companywpuser_nominee_shareholder->person_type = 'shareholder';
        //     $companywpuser_nominee_shareholder->save();
        // }

        //////

        // $companywpuser_nominee_director = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'director')->first();

        // if(empty($companywpuser_nominee_director)) {
        //     $companywpuser_nominee_director = new CompanyWpuserNominee;
        // }

        // if(!empty($request->input('nominee_director_name')) && !empty($request->input('nominee_director_address')) && !empty($request->input('nominee_director_telephone')) ) {
        //     $companywpuser_nominee_director->companywpuser_id = $companywpuser_id;
        //     $companywpuser_nominee_director->name = $request->input('nominee_director_name');
        //     $companywpuser_nominee_director->address = $request->input('nominee_director_address');
        //     $companywpuser_nominee_director->address_2 = $request->input('nominee_director_address_2');
        //     $companywpuser_nominee_director->address_3 = $request->input('nominee_director_address_3');
        //     $companywpuser_nominee_director->address_4 = $request->input('nominee_director_address_4');
        //     $companywpuser_nominee_director->telephone = $request->input('nominee_director_telephone');
        //     $companywpuser_nominee_director->person_type = 'director';
        //     $companywpuser_nominee_director->save();
        // }

        //////

        // $companywpuser_nominee_secretary = CompanyWpuserNominee::where('companywpuser_id', $companywpuser_id)->where('person_type', 'secretary')->first();

        // if(empty($companywpuser_nominee_secretary)) {
        //     $companywpuser_nominee_secretary = new CompanyWpuserNominee;
        // }

        // if(!empty($request->input('nominee_secretary_name')) && !empty($request->input('nominee_secretary_address')) && !empty($request->input('nominee_secretary_telephone')) ) {
        //     $companywpuser_nominee_secretary->companywpuser_id = $companywpuser_id;
        //     $companywpuser_nominee_secretary->name = $request->input('nominee_secretary_name');
        //     $companywpuser_nominee_secretary->address = $request->input('nominee_secretary_address');
        //     $companywpuser_nominee_secretary->address_2 = $request->input('nominee_secretary_address_2');
        //     $companywpuser_nominee_secretary->address_3 = $request->input('nominee_secretary_address_3');
        //     $companywpuser_nominee_secretary->address_4 = $request->input('nominee_secretary_address_4');
        //     $companywpuser_nominee_secretary->telephone = $request->input('nominee_secretary_telephone');
        //     $companywpuser_nominee_secretary->person_type = 'secretary';
        //     $companywpuser_nominee_secretary->save();
        // }

        ////
        //// updating persons fields
        ////

        $companywpuser_directors = CompanyWpuserDirector::where('companywpuser_id', $companywpuser_id)->get();
        $companywpuser_shareholders = CompanyWpuserShareholder::where('companywpuser_id', $companywpuser_id)->get();
        $companywpuser_secretaries = CompanyWpuserSecretary::where('companywpuser_id', $companywpuser_id)->get();        

        foreach ($companywpuser_shareholders as $key => $companywpuser_shareholder) {
            $no = $key + 1;
            $companywpuser_shareholder->type = $request->input('shareholder_'.$no.'_type'); 
            $companywpuser_shareholder->name = $request->input('shareholder_'.$no.'_name');
            $companywpuser_shareholder->address = $request->input('shareholder_'.$no.'_address');
            $companywpuser_shareholder->address_2 = $request->input('shareholder_'.$no.'_address_2');
            $companywpuser_shareholder->address_3 = $request->input('shareholder_'.$no.'_address_3');
            $companywpuser_shareholder->address_4 = $request->input('shareholder_'.$no.'_address_4');
            $companywpuser_shareholder->telephone = $request->input('shareholder_'.$no.'_telephone');
            $companywpuser_shareholder->passport = $request->input('shareholder_'.$no.'_passport');
            $companywpuser_shareholder->bill = $request->input('shareholder_'.$no.'_bill');
            $companywpuser_shareholder->shareholder = $request->input('shareholder_'.$no.'_shareholder');
            $companywpuser_shareholder->beneficial = $request->input('shareholder_'.$no.'_beneficial');
            $companywpuser_shareholder->share_amount = $request->input('shareholder_'.$no.'_share_amount');
            $companywpuser_shareholder->save();
        }

        foreach ($companywpuser_directors as $key => $companywpuser_director) {
            $no = $key + 1;
            $companywpuser_director->type = $request->input('director_'.$no.'_type'); 
            $companywpuser_director->name = $request->input('director_'.$no.'_name');
            $companywpuser_director->address = $request->input('director_'.$no.'_address');
            $companywpuser_director->address_2 = $request->input('director_'.$no.'_address_2');
            $companywpuser_director->address_3 = $request->input('director_'.$no.'_address_3');
            $companywpuser_director->address_4 = $request->input('director_'.$no.'_address_4');
            $companywpuser_director->telephone = $request->input('director_'.$no.'_telephone');
            $companywpuser_director->passport = $request->input('director_'.$no.'_passport');
            $companywpuser_director->bill = $request->input('director_'.$no.'_bill');
            $companywpuser_director->save();
        }

        foreach ($companywpuser_secretaries as $key => $companywpuser_secretary) {
            $no = $key + 1;
            $companywpuser_secretary->type = $request->input('secretary_'.$no.'_type'); 
            $companywpuser_secretary->name = $request->input('secretary_'.$no.'_name');
            $companywpuser_secretary->address = $request->input('secretary_'.$no.'_address');
            $companywpuser_secretary->address_2 = $request->input('secretary_'.$no.'_address_2');
            $companywpuser_secretary->address_3 = $request->input('secretary_'.$no.'_address_3');
            $companywpuser_secretary->address_4 = $request->input('secretary_'.$no.'_address_4');
            $companywpuser_secretary->telephone = $request->input('secretary_'.$no.'_telephone');
            $companywpuser_secretary->passport = $request->input('secretary_'.$no.'_passport');
            $companywpuser_secretary->bill = $request->input('secretary_'.$no.'_bill');
            $companywpuser_secretary->save();
        }

        return redirect('admin/registeredcompany');
        

    }

}
