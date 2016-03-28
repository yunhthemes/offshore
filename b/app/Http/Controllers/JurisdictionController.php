<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
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
    public function index(Request $request)
    {
        //
        if($request->ajax() || $request->callback)
        {
            $company_types = CompanyType::with('directors', 'shareholders', 'secretaries', 'services', 'informationservices')->get();    
            return response()->json($company_types)->setCallback($request->input('callback'));
        }

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
        $countries = Country::lists('name', 'id');

        return view('jurisdiction.create', ['countries' => $countries]);

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
        $company_type->price = (double) preg_replace("/[^0-9,.]/", "", $request->company_type_price);
        $company_type->price_eu = (double) preg_replace("/[^0-9,.]/", "", $request->company_type_price_eu);
        $company_type->rules = 'company rules?';
        $company_type->save();

        if($company_type->id) {

            if(!empty($request->director_name_rules) && !empty($request->director_price) && !empty($request->director_price_eu)) {
                $director = new Director;
                $director->name_rules = $request->director_name_rules;
                $director->price = (double) preg_replace("/[^0-9,.]/", "", $request->director_price);   
                $director->price_eu = (double) preg_replace("/[^0-9,.]/", "", $request->director_price_eu);   
                $director->company_type_id = $company_type->id;   
                $director->save();
            }

            if(!empty($request->shareholder_name_rules) && !empty($request->shareholder_price) && !empty($request->shareholder_price_eu)) {
                $shareholder = new Shareholder;
                $shareholder->name_rules = $request->shareholder_name_rules;
                $shareholder->price = (double) preg_replace("/[^0-9,.]/", "", $request->shareholder_price);
                $shareholder->price_eu= (double) preg_replace("/[^0-9,.]/", "", $request->shareholder_price_eu);
                $shareholder->company_type_id = $company_type->id;       
                $shareholder->save();
            }

            if(!empty($request->secretary_name_rules) && !empty($request->secretary_price) && !empty($request->secretary_price_eu)) {
                $secretary = new Secretary;
                $secretary->name_rules = $request->secretary_name_rules;
                $secretary->price = (double) preg_replace("/[^0-9,.]/", "", $request->secretary_price);    
                $secretary->price_eu = (double) preg_replace("/[^0-9,.]/", "", $request->secretary_price_eu);    
                $secretary->company_type_id = $company_type->id;       
                $secretary->save();
            }

            $count = $request->service_1_count;

            if(!empty($request->service_1_name) && !empty($request->input('service_1_price_1'))) {
                $service = new Service();
                $service->name = $request->service_1_name;
                $service->company_type_id = $company_type->id;    
                $service->save();

                for($i=1;$i<=$count;$i++):
                    if(!empty($request->input('service_1_name')) && !empty($request->input('service_1_country_'.$i)) && !empty($request->input('service_1_price_'.$i)) && !empty($request->input('service_1_price_eu_'.$i))):
                        
                        $country = Country::find($request->input('service_1_country_'.$i));
                        $price = (double) preg_replace("/[^0-9,.]/", "", $request->input('service_1_price_'.$i));
                        $price_eu = (double) preg_replace("/[^0-9,.]/", "", $request->input('service_1_price_eu_'.$i));
                        $country->services()->attach($service->id, ['price' => $price, 'price_eu' => $price_eu]);
                        
                    endif;                
                endfor;
            }

            $count = $request->service_2_count;

            if(!empty($request->service_2_name) && !empty($request->input('service_2_price_1'))) {

                $service = new Service();
                $service->name = $request->service_2_name;
                $service->company_type_id = $company_type->id;    
                $service->save();

                for($i=1;$i<=$count;$i++):
                    if(!empty($request->input('service_2_name')) && !empty($request->input('service_2_country_'.$i)) && !empty($request->input('service_2_price_'.$i)) && !empty($request->input('service_2_price_eu_'.$i))):
                        
                        $country = Country::find($request->input('service_2_country_'.$i));
                        $price = (double) preg_replace("/[^0-9,.]/", "", $request->input('service_2_price_'.$i));
                        $price_eu = (double) preg_replace("/[^0-9,.]/", "", $request->input('service_2_price_eu_'.$i));
                        $country->services()->attach($service->id, ['price' => $price, 'price_eu' => $price_eu]);                        
                                        
                    endif;                
                endfor;
            }

            $count = $request->service_3_count;

            if(!empty($request->service_3_name) && !empty($request->input('service_3_price_1'))) {

                $service = new Service();
                $service->name = $request->service_3_name;
                $service->company_type_id = $company_type->id;    
                $service->save();                

                for($i=1;$i<=$count;$i++):
                    if(!empty($request->input('service_3_name')) && !empty($request->input('service_3_country_'.$i)) && !empty($request->input('service_3_price_'.$i)) && !empty($request->input('service_3_price_eu_'.$i))):

                        $country = Country::find($request->input('service_3_country_'.$i));
                        $price = (double) preg_replace("/[^0-9,.]/", "", $request->input('service_3_price_'.$i));
                        $price_eu = (double) preg_replace("/[^0-9,.]/", "", $request->input('service_3_price_eu_'.$i));
                        $country->services()->attach($service->id, ['price' => $price, 'price_eu' => $price_eu]);                                            
                        
                    endif;                
                endfor;
            }

            $count = $request->service_4_count;

            if(!empty($request->service_4_name) && !empty($request->input('service_4_price_1'))) {

                $service = new Service();
                $service->name = $request->service_4_name;
                $service->company_type_id = $company_type->id;    
                $service->save();                

                for($i=1;$i<=$count;$i++):
                    if(!empty($request->input('service_4_name')) && !empty($request->input('service_4_country_'.$i)) && !empty($request->input('service_4_price_'.$i)) && !empty($request->input('service_4_price_eu_'.$i))):
                        
                        $country = Country::find($request->input('service_4_country_'.$i));
                        $price = (double) preg_replace("/[^0-9,.]/", "", $request->input('service_4_price_'.$i));
                        $price_eu = (double) preg_replace("/[^0-9,.]/", "", $request->input('service_4_price_eu_'.$i));
                        $country->services()->attach($service->id, ['price' => $price, 'price_eu' => $price_eu]);     
                        // $country->services()->attach($service->id, ['price' => $request->input('service_4_price_'.$i), 'price_eu' => $request->input('service_4_price_eu_'.$i)]);                    
                        
                    endif;                
                endfor;
            }

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
    public function show(Request $request, $id)
    {
        //
        // DB::enableQueryLog();
        $company_type = CompanyType::with('directors', 'shareholders', 'secretaries', 'services.countries', 'informationservices')->find($id);        
        
        if($request->ajax() || $request->callback)
        {
            $companies = CompanyType::with('companies','shareholders', 'directors', 'secretaries', 'services.countries', 'informationservices')->find($id);    

            $companies = CompanyType::with(['companies' => function($query){
                $query->where('shelf', 1)->where('wpuser_id', NULL); // only shelf compaines without owner return
            }, 'shareholders', 'directors', 'secretaries', 'services.countries', 'informationservices'])->find($id);

            foreach ($companies->companies as $key => $company) {
                $company->incorporation_date = date('d M Y', strtotime($company->incorporation_date));
            }

            // print_r(DB::getQueryLog()); exit();

            return response()->json($companies)->setCallback($request->input('callback'));
            
        }

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
