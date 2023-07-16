<?php

namespace App\Http\Controllers;

use App\Models\RequestCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Carset1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = 93;
        $departmentcheck = Auth::user()->department_id;
        $carset = RequestCar::All();

        if (Auth::user()->permission_id == 1) {
            $carset = RequestCar::where('status_id', 3)->paginate(10);

            if (count($carset) == 0) {
                return view('user.carset1', compact('carset', 'a'));
            }

            return view('user.carset1', compact('carset', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }

        $carset = RequestCar::where('department_car', $departmentcheck)
            ->where('status_id', 3)->paginate(10);

        if (count($carset) == 0) {
            return view('user.carset1', compact('carset', 'a'));
        }

        return view('user.carset1', compact('carset', 'a'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
