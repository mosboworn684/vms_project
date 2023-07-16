<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Prefix;
use App\Models\Statusdriver;
use Illuminate\Http\Request;

class DriverdontactiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $a = 6;
        $data = Driver::where('active', 0)->get();
        $prefix = Prefix::All();
        $status = Statusdriver::All();

        if (count($data) == 0) {
            return view('admin.menucar.driverdontactive', compact('data', 'a', 'prefix', 'status'));
        }

        $data = Driver::where('active', 0)->paginate(10);

        return view('admin.menucar.driverdontactive', compact('data', 'a', 'prefix', 'status'))
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
        $driver = Driver::find($id);

        $driver->active = 1;
        $driver->save();

        return redirect()->route('driverdontactive.index')
            ->with('success', 'บัญชีที่เลือกเปิดการใช้งานแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Driver::destroy($id);

        return redirect()->route('driverdontactive.index')
            ->with('success', 'ลบพนักงานขับรถสำเร็จ');
    }
}
