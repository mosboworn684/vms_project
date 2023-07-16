<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = 1;
        $data = Color::all();
        if (count($data) == 0) {

            return view('admin.menucar.addcolor', compact('data', 'a'));
        }
        $data = Color::first()->paginate(10);
        return view('admin.menucar.addcolor', compact('data', 'a'))
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
        $color = new Color;
        if (Color::where('name', $request->name)->exists()) {
            return redirect()->route('addcolor.index')
                ->with('error', 'มีสีนี้อยู่แล้ว');
        }
        $color->name = $request->name;
        $color->save();
        return redirect()->route('addcolor.index')
            ->with('success', 'เพิ่มสีรถสำเร็จ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit(Color $color)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $color = Color::find($id);

        if (Color::where('name', $request->name)->exists()) {
            return redirect()->route('addcolor.index')
                ->with('error', 'มีสีนี้อยู่แล้ว');
        }

        if (Car::where('color_id', $id)->exists()) {
            return redirect()->route('addcolor.index')
                ->with('error', 'มีรถที่ใช้สีนี้อยู่ไม่สามารถแก้ไขได้');
        }

        $color->name = $request->name;
        $color->save();

        return redirect()->route('addcolor.index')
            ->with('success', 'แก้ไขสีรถยนต์สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Car::where('color_id', $id)->exists()) {
            return redirect()->route('addcolor.index')
                ->with('error', 'สีนี้มีการใช้งานอยู่ กรุณาตรวจสอบรถยนต์');
        }

        Color::destroy($id);

        return redirect()->route('addcolor.index')
            ->with('success', 'ลบสีรถสำเร็จ');
        //
    }
}
