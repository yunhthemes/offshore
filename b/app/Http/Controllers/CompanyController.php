<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Keypersonnel;
use App\Service;
use App\Company;
use App\CompanyType;
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
        //
        // return $request->all();

    	$company = new Company();

        if(!empty($request->company_name) && !empty($request->company_incorporation_date) && !empty($request->company_type) && !empty($request->company_price)) {
            $company->name = $request->company_name;
            $company->incorporation_date = $request->company_incorporation_date;
            $company->price = $request->company_price;
            $company->shelf = 1;
            $company->company_type_id = $request->company_type;
            $company->save();    
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

    	return redirect('admin/company');

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
