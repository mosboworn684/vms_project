<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $model = new CarModel();

        if (CarModel::where('name', $request->name)
            ->where('brand_id', $request->brand_id)->exists()) {
            return back()->with('error', 'มีรถยนต์รุ่นนี้แล้ว');
        }

        $model->name = $request->name;
        $model->brand_id = $request->brand_id;
        $model->save();

        return back()->with('success', 'เพิ่มรุ่นรถยนต์สำเร็จ');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::where('id', $id)->get();
        $model = CarModel::where('brand_id', $id)->paginate(10);

        return view('admin.menucar.addmodel', compact('model', 'brand'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function edit(CarModel $carModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carmodel = CarModel::find($id);

        if (CarModel::where('name', $request->name)
            ->where('brand_id', $request->brand_id)->exists()) {
            return back()->with('error', 'มีรถยนต์รุ่นนี้แล้ว');
        }
        if (Car::where('brand_id', $request->brand_id)
            ->where('model_id', $id)->exists()) {
            return back()->with('error', 'มีรถที่ใช้รุ่นนี้อยู่ไม่สามารถแก้ไขได้');
        }
        $carmodel->name = $request->name;
        $carmodel->save();

        return back()->with('success', 'แก้ไขรุ่นรถยนต์สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Car::where('model_id', $id)->exists()) {
            return back()->with('error', 'ต้องลบรถรุ่นนี้ทั้งหมดก่อน');
        }

        CarModel::destroy($id);

        return back()->with('success', 'ลบรุ่นรถยนต์สำเร็จ');
    }
}
