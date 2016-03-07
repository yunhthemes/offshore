<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CompanyType;
use App\Company;
use App\Director;
use App\Shareholder;
use App\Secretary;
use App\Service;
use App\InformationService;
use App\Http\Requests;
use App\Http\Controllers\Controller;
Use DB;

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
        // return $request->all();

        $company_type = new CompanyType;
        $company_type->name = $request->company_type_name;
        $company_type->price = $request->company_type_price;
        $company_type->rules = $request->company_type_rules;
        $company_type->save();

        if($company_type->id) {

            if(!empty($request->director_name_rules) && !empty($request->director_price)) {
                $director = new Director;
                $director->name_rules = $request->director_name_rules;
                $director->price = $request->director_price;   
                $director->company_type_id = $company_type->id;   
                $director->save();
            }

            if(!empty($request->shareholder_name_rules) && !empty($request->shareholder_price)) {
                $shareholder = new Shareholder;
                $shareholder->name_rules = $request->shareholder_name_rules;
                $shareholder->price = $request->shareholder_price;
                $shareholder->company_type_id = $company_type->id;       
                $shareholder->save();
            }

            if(!empty($request->secretary_name_rules) && !empty($request->secretary_price)) {
                $secretary = new Secretary;
                $secretary->name_rules = $request->secretary_name_rules;
                $secretary->price = $request->secretary_price;    
                $secretary->company_type_id = $company_type->id;       
                $secretary->save();
            }

            $count = $request->service_1_count;

            for($i=1;$i<=$count;$i++):
                if(!empty($request->input('service_1_name')) && !empty($request->input('service_1_country_'.$i)) && !empty($request->input('service_1_price_'.$i))):
                     $service = new Service();
                    $service->name = $request->service_1_name;
                    $service->country = $request->input('service_1_country_'.$i);
                    $service->price = $request->input('service_1_price_'.$i);
                    $service->company_type_id = $company_type->id;    
                    $service->save();                   
                endif;                
            endfor;

            $count = $request->service_2_count;

            for($i=1;$i<=$count;$i++):
                if(!empty($request->input('service_2_name')) && !empty($request->input('service_2_country_'.$i)) && !empty($request->input('service_2_price_'.$i))):
                    $service = new Service();
                    $service->name = $request->service_2_name;
                    $service->country = $request->input('service_2_country_'.$i);
                    $service->price = $request->input('service_2_price_'.$i);
                    $service->company_type_id = $company_type->id;    
                    $service->save();                
                endif;                
            endfor;

            $count = $request->service_3_count;

            for($i=1;$i<=$count;$i++):
                if(!empty($request->input('service_3_name')) && !empty($request->input('service_3_country_'.$i)) && !empty($request->input('service_3_price_'.$i))):
                    $service = new Service();
                    $service->name = $request->service_3_name;
                    $service->country = $request->input('service_3_country_'.$i);
                    $service->price = $request->input('service_3_price_'.$i);
                    $service->company_type_id = $company_type->id;    
                    $service->save();                
                endif;                
            endfor;

            $count = $request->service_4_count;

            for($i=1;$i<=$count;$i++):
                if(!empty($request->input('service_4_name')) && !empty($request->input('service_4_country_'.$i)) && !empty($request->input('service_4_price_'.$i))):
                    $service = new Service();
                    $service->name = $request->service_4_name;
                    $service->country = $request->input('service_4_country_'.$i);
                    $service->price = $request->input('service_4_price_'.$i);
                    $service->company_type_id = $company_type->id;    
                    $service->save();                
                endif;                
            endfor;

            $count = $request->information_service_count;

            for($i=1;$i<=$count;$i++):
                if(!empty($request->input('information_service_'.$i))):
                    $information_service = new InformationService();
                    $information_service->name = $request->input('information_service_'.$i);                    
                    $information_service->company_type_id = $company_type->id;    
                    $information_service->save();
                endif;
            endfor;
            
        }     

        // if($company_type->id) {

            // $company = new Company;
            // $company->name = $request->company_name;            
            // $company->incorporation_date = $request->company_incorporation_date;
            // $company->price = $request->company_price;
            // $company->shelf = $request->shelf_company;
            // $company->company_type_id = $company_type->id;
            // $company->save();

            // $service = new Service;
            // $service->name = $request->service_name;
            // $service->save();

            // $company_type = CompanyType::find($company_type->id);
            // $company_type->services()->attach($service->id, ['price' => $request->service_price]);

        // }

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
        // DB::enableQueryLog();
        $company_type = CompanyType::with('directors', 'shareholders', 'secretaries', 'services', 'informationservices')->find($id);
        // print_r(DB::getQueryLog());

        return view('jurisdiction.show', [ 'company_type' => $company_type ]);
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
