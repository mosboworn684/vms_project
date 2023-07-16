<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Typecar;
use Illuminate\Http\Request;

class TypecarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $a = 5;
        $data = Typecar::all();
        if (count($data) == 0) {

            return view('admin.menucar.typecar', compact('data', 'a'));
        }
        $data = Typecar::first()->paginate(10);
        return view('admin.menucar.typecar', compact('data', 'a'))
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

        $type = new Typecar();
        if (Typecar::where('name', $request->name)->exists()) {
            return redirect()->route('typecar.index')
                ->with('error', 'มีประเภทรถยนต์อยู่แล้ว');
        }
        $type->name = $request->name;
        $type->save();
        return redirect()->route('typecar.index')
            ->with('success', 'เพิ่มประเภทรถยนต์สำเร็จ');

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
        $typecar = Typecar::find($id);

        if (Typecar::where('name', $request->name)->exists()) {
            return redirect()->route('typecar.index')
                ->with('error', 'มีรถที่ใช้ประเภทนี้อยู่ไม่สามารถแก้ไขได้');
        }

        if (Car::where('type_id', $id)->exists()) {
            return redirect()->route('typecar.index')
                ->with('error', 'มีรถที่ใช้ประเภทนี้อยู่ไม่สามารถแก้ไขได้');
        }

        $typecar->name = $request->name;
        $typecar->save();

        return redirect()->route('typecar.index')
            ->with('success', 'แก้ไขประเภทยนต์รถยนต์สำเร็จ');
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
        if (Car::where('type_id', $id)->exists()) {
            return redirect()->route('typecar.index')
                ->with('error', 'ประเภทรถยนต์นี้มีการใช้งานอยู่ กรุณาตรวจสอบรถยนต์');
        }

        Typecar::destroy($id);

        return redirect()->route('typecar.index')
            ->with('success', 'ลบประเภทรถยนต์สำเร็จ.');
    }
}
