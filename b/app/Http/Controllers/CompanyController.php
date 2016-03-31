<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Keypersonnel;
use App\Service;
use App\Company;
use App\CompanyType;
use App\CompanyDirector;
use App\CompanySecretary;
use App\CompanyShareholder;
use App\Country;
use App\Wpuser;
use App\InformationService;
use App\Http\Requests;
use App\Http\Controllers\Controller;
Use DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    	// DB::enableQueryLog();
        // DB::getQueryLog();

        $companies = Company::with('companytypes')->where('shelf', 1)->get();              
        return view('company.index', ['companies'=>$companies]);            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    	$company_types = CompanyType::lists('name', 'id');        

        return view('company.create', ['company_types'=>$company_types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       

        // return $request->all();

        if($request->ajax() || $request->callback) {

            $user_id = $request->user_id;

            if(empty($user_id) || $user_id==0) { // for unregistered user testing
                $user_id = 1;
            }

            $company_id = $request->shelf_company_id;

            if(empty($company_id)) { // if not shelf create new company
                $company = new Company;
                $company->name = implode(", ", $request->company_name_choices);
                $company->incorporation_date = date('Y-m-d H:i:s');
                $company->price = 0;
                $company->price_eu = 0;
                $company->company_type_id = $request->jurisdiction_id;
                $company->renewal_date = date('Y-m-d H:i:s', strtotime(date("Y-m-d", time()) . " + 365 day"));
                $company->save();

                $company_id = $company->id;
            }            

            if(!empty($user_id) && !empty($company_id) && $user_id!==0):

                $company = Company::find($company_id);
                $company->renewal_date = date('Y-m-d H:i:s', strtotime(date("Y-m-d", time()) . " + 365 day"));
                $wpuser = Wpuser::find($user_id);
                $company->wpuser()->associate($wpuser);
                $company->save();

                // $company->wpusers()->attach($wpuser->ID); // might change to one to many which is to add user_id in compaines table

                $directors = array();
                $secretaries = array();
                $shareholders = array();

                for($i=1;$i<=$request->director_count;$i++) {                
                    $name = $request->input('director_'.$i.'_name');
                    $address = $request->input('director_'.$i.'_address');
                    $address_2 = $request->input('director_'.$i.'_address_2');
                    $address_3 = $request->input('director_'.$i.'_address_3');
                    $directors[] = new CompanyDirector(['name'=>$name, 'address'=>$address, 'address_2'=>$address_2, 'address_3'=>$address_3]);
                }

                for($i=1;$i<=$request->secretary_count;$i++) {                
                    $name = $request->input('secretary_'.$i.'_name');
                    $address = $request->input('secretary_'.$i.'_address');
                    $address_2 = $request->input('secretary_'.$i.'_address_2');
                    $address_3 = $request->input('secretary_'.$i.'_address_3');
                    $secretaries[] = new CompanySecretary(['name'=>$name, 'address'=>$address, 'address_2'=>$address_2, 'address_3'=>$address_3]);
                }

                for($i=1;$i<=$request->shareholder_count;$i++) {                
                    $name = $request->input('shareholder_'.$i.'_name');
                    $address = $request->input('shareholder_'.$i.'_address');
                    $address_2 = $request->input('shareholder_'.$i.'_address_2');
                    $address_3 = $request->input('shareholder_'.$i.'_address_3');
                    $amount = $request->input('shareholder_'.$i.'_amount');
                    $shareholders[] = new CompanyShareholder(['name'=>$name, 'address'=>$address, 'address_2'=>$address_2, 'address_3'=>$address_3, 'share_amount'=>$amount]);
                }

                $company->companydirectors()->saveMany($directors);
                $company->companysecretaries()->saveMany($secretaries);
                $company->companyshareholders()->saveMany($shareholders);

                for($i=1;$i<=$request->service_count;$i++) {
                    $service_country_count = $request->input('service_'.$i.'_country_count');

                    for($j=1;$j<=$service_country_count;$j++) {
                        $service_country_id = $request->input('service_'.$i.'_country_'.$j.'_id'); 
                        $credit_card_count = ($request->input('service_'.$i.'_country_'.$j.'_no_of_card')) ? $request->input('service_'.$i.'_country_'.$j.'_no_of_card') : "";

                        $company->servicescountries()->attach($service_country_id, ['credit_card_count'=>$credit_card_count]);
                    }
                }

                $info_services_ids = $request->info_services_id;
                $company_info_services = array();

                if($info_services_ids) {
                    foreach ($info_services_ids as $key => $value) {
                        $company->informationservice()->attach($value);
                    }    
                }                

                return response()->json(['message' => 'Successfully added', 'response' => $request->all()], 200)->setCallback($request->input('callback'));

            else:

                return response()->json(['message' => 'missing required fields'], 412);

            endif;

        }else {

            if(!empty($request->company_name) && !empty($request->company_incorporation_date) && !empty($request->company_type) && !empty($request->company_price)) {
                $company = new Company();
                $company->name = $request->company_name;
                $company->incorporation_date = $request->company_incorporation_date;
                $company->price = (double) preg_replace("/[^0-9,.]/", "", $request->company_price);
                $company->price_eu = (double) preg_replace("/[^0-9,.]/", "", $request->company_price_eu);
                $company->shelf = 1;
                $company->company_type_id = $request->company_type;
                $company->save();
            }

            return redirect('admin/company');
        }  	

        // foreach($request->services as $key => $service_id) {
        //     $company->services()->attach($service_id);
        // }

        // if(!empty($request->shareholders)){        
        //     foreach ($request->shareholders as $key => $shareholder_id) {
        //         $company->keypersonnel()->attach($shareholder_id, ['share_amount' => $request->input('shareholder_'.$shareholder_id.'_share_amount')]);
        //     }
        // }

        // if(!empty($request->directors)){
        //     foreach ($request->directors as $key => $director_id) {            
        //         $company->keypersonnel()->attach($director_id);
        //     }
        // }
        
        // if(!empty($request->secretaries)){
        //     foreach ($request->secretaries as $key => $secretary_id) {
        //         $company->keypersonnel()->attach($secretary_id);
        //     }
        // }    	

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //              
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
