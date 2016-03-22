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
use App\WpuserCompany;
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

        $companies = Company::with('companytypes')->get();

        if($request->ajax())
        {
            return $companies;
        }    	

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

            // if(empty($request->shelf_company_id)) {
                
            // }
            $wpuser_company = new WpuserCompany();
            $wpuser_company->wpuser_id = $request->user_id;
            $wpuser_company->company_id = $request->shelf_company_id;
            $wpuser_company->save();

            $company = Company::find($request->shelf_company_id);
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

            // save service
            // save info service

            return response()->json(['message' => 'Successfully added', 'response' => $request->all()], 200)->setCallback($request->input('callback'));

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
    public function show($id)
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
