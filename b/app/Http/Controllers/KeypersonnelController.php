<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Keypersonnel;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class KeypersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $keypersonnel = Keypersonnel::all();
        
        return view('keypersonnel.index', ['keypersonnel' => $keypersonnel]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('keypersonnel.create');
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
        $keypersonnel = new Keypersonnel();
        $keypersonnel->name = $request->keypersonnel_name;
        $keypersonnel->price = $request->keypersonnel_price;
        $keypersonnel->offshore = 1;
        $keypersonnel->role = $request->keypersonnel_role;
        $keypersonnel->passport = $request->keypersonnel_passport;
        $keypersonnel->utility_bill = $request->keypersonnel_utility_bill;
        $keypersonnel->save();

        return redirect('admin/keypersonnel');
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
