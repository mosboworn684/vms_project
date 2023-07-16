<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $a = 2;
        $data = Brand::all();
        if (count($data) == 0) {

            return view('admin.menucar.addbrand', compact('data', 'a'));
        }
        $data = Brand::first()->paginate(10);
        return view('admin.menucar.addbrand', compact('data', 'a'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //add
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
        $brand = new Brand();
        if (Brand::where('name', $request->name)->exists()) {
            return redirect()->route('brand.index')
                ->with('error', 'มียี่ห้อนี้อยู่แล้ว');
        }
        $brand->name = $request->name;
        $brand->save();
        return redirect()->route('brand.index')
            ->with('success', 'เพิ่มยี่ห้อสำเร็จ');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        $a = 4;
        return view('admin.menucar.addmodel', compact('brand', 'a'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brandcar = Brand::find($id);

        if (Brand::where('name', $request->name)->exists()) {
            return redirect()->route('brand.index')
                ->with('error', 'มียี่ห้อนี้อยู่แล้ว');
        }

        if (Car::where('brand_id', $id)->exists()) {
            return redirect()->route('brand.index')
                ->with('error', 'มีรถที่ใช้ยี่ห้อนี้อยู่ไม่สามารถแก้ไขได้');
        }

        $brandcar->name = $request->name;
        $brandcar->save();

        return redirect()->route('brand.index')
            ->with('success', 'แก้ไขยี่ห้อรถยนต์สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        if (Car::where('brand_id', $id)->exists()) {
            return redirect()->route('brand.index')
                ->with('error', 'ต้องลบรถยี่ห้อนี้ทั้งหมดก่อน');
        }

        Brand::destroy($id);
        CarModel::where('brand_id', $id)->delete();

        return redirect()->route('brand.index')
            ->with('success', 'ลบยี่ห้อรถยนต์สำเร็จ');
    }

}
