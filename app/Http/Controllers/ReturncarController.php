<?php

namespace App\Http\Controllers;

use App\Models\RequestCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturncarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = 91;
        $departmentcheck = Auth::user()->department_id;
        $datetime = date("Y-m-d H:i");
        //พนักงาน
        if (Auth::user()->permission_id == 3) {
            $data = RequestCar::where('user_id', Auth::user()->id)
                ->where('status_id', 4)->paginate(10);
            if (count($data) == 0) {
                return view('user.returncar', compact('data', 'a', 'datetime'));
            }

            return view('user.returncar', compact('data', 'a', 'datetime'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }
        //หัวหน้าแผนก
        if (Auth::user()->permission_id == 2) {
            $data = RequestCar::where('status_id', 4)
                ->where('department_car', $departmentcheck)
                ->paginate(10);

            return view('user.returncar', compact('data', 'a', 'datetime'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        }
        //แอดมิน
        if (Auth::user()->permission_id == 1) {
            $data = RequestCar::where('status_id', 4)->paginate(10);
            return view('user.returncar', compact('data', 'a', 'datetime'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        }
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
    public function viewImage(){
        $imageData= RequestCar::all();
        return view('user.image', compact('imageData'));
    }

}
