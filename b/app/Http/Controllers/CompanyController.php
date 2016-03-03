<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function index()
    {
        //
    	// DB::enableQueryLog();

    	$companies = Company::with('companytypes')->get();

    	// DB::getQueryLog();

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
    	$company = new Company();

    	$company->name = $request->company_name;
    	$company->incorporation_date = $request->company_incorporation_date;
    	$company->price = $request->company_price;
    	$company->shelf = $request->shelf_company;
    	$company->company_type_id = $request->company_type;
    	$company->save();

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
