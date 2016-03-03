<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CompanyType;
use App\Company;
use App\Service;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class JurisdictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $company_types = CompanyType::all();     

        return view('jurisdiction.index', ['company_types' => $company_types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('jurisdiction.create');

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
        $company_type = new CompanyType;
        $company_type->name = $request->company_type_name;
        $company_type->price = $request->company_type_price;
        $company_type->save();

        if($company_type->id) {

            $company = new Company;
            $company->name = $request->company_name;            
            $company->incorporation_date = $request->company_incorporation_date;
            $company->price = $request->company_price;
            $company->shelf = $request->shelf_company;
            $company->company_type_id = $company_type->id;
            $company->save();

            $service = new Service;
            $service->name = $request->service_name;
            $service->save();

            $company_type = CompanyType::find($company_type->id);
            $company_type->services()->attach($service->id, ['price' => $request->service_price]);

        }

        return redirect('admin/jurisdiction');
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
