<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service;
use App\CompanyType;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $services = Service::with('companytypes')->get();  

        // return $services;      

        return view('service.index', ['services'=>$services]);
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

        return view('service.create', ['company_types'=>$company_types]);
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
        $service = new Service();
        $service->name = $request->service_name;
        $service->save();

        $count = $request->company_type_count;

        for($i=1;$i<=$count;$i++):
            $company_type_id = $request->input('company_type_id_'.$i);
            $service_price = $request->input('service_price_'.$i);
            $service->companytypes()->attach($company_type_id, ['price' => $service_price]);
        endfor;
        
        return redirect('admin/service');

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
