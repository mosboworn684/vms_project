<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\CarStatus;
use App\Models\Color;
use App\Models\Department;
use App\Models\province;
use App\Models\RequestCar;
use App\Models\Typecar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $a = 4;
        $departmentcheck = Auth::user()->department_id;
        $typecar = Typecar::all();
        $color = Color::all();
        $brand = Brand::all();
        $status = CarStatus::all();
        $department = Department::all();
        $province = province::all();

        if (Auth::user()->permission_id == 1) {
            $car = Car::where('active', 1)
                ->get();

            if (count($car) == 0) {

                return view('admin.menucar.carlist', compact('car', 'a', 'typecar', 'color', 'brand', 'status', 'department','province'));
            }

            $car = Car::where('active', 1)
                ->orderBy('department_id', 'asc')
                ->orderBy('type_id', 'asc')
                ->orderBy('capacity', 'asc')
                ->paginate(10);

            return view('admin.menucar.carlist', compact('car', 'a', 'typecar', 'color', 'brand', 'status', 'department','province'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }

        $car = Car::where('active', 1)
            ->get();

        if (count($car) == 0) {
            return view('admin.menucar.carlist', compact('car', 'a', 'typecar', 'color', 'brand', 'status', 'department','province'));
        }

        $car = Car::where('active', 1)
            ->where('department_id', $departmentcheck)
            ->orderBy('type_id', 'asc')
            ->orderBy('capacity', 'asc')
            ->paginate(10);

        return view('admin.menucar.carlist', compact('car', 'a', 'typecar', 'color', 'brand', 'status', 'department','province'))
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
        $car = new Car();

        if (Car::where('regisNumber', $request->regisNumber)->exists()) {
            return redirect()->route('carlist.index')
                ->with('error', 'มีรถยนต์ทะเบียนนี้อยู่แล้ว');
        }

        $car->regisNumber = $request->regisNumber;
        $car->type_id = $request->type_id;
        $car->brand_id = $request->brand_id;
        $car->model_id = $request->model_id;
        $car->color_id = $request->color_id;
        $car->province_id = $request->province_id;
        $car->department_id = $request->department_id;
        $car->capacity = $request->capacity;
        $car->mileage = $request->mileage;
        $car->status_id = 1;
        $car->active = 1;

        $car->save();

        return redirect()->route('carlist.index')
            ->with('success', 'เพิ่มรถยนต์สำเร็จ.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $a = 4;
        $car = Car::where('id', $id)->get();

        return view('admin.menuuser.edituser', compact('a', 'car'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $car = Car::find($id);

        $car->regisNumber = $request->regisNumber;

        $car->type_id = $request->type_id;
        $car->brand_id = $request->brand_id;
        $car->model_id = $request->model_id;
        $car->color_id = $request->color_id;
        $car->department_id = $request->department_id;

        // if ($request->mileage < $car->mileage) {
        //     return redirect()->route('carlist.index')
        //         ->with('error', 'ใส่เลขไมค์ให้ถูกต้อง');
        // }
        $car->capacity = $request->capacity;
        $car->mileage = $request->mileage;
        $car->status_id = $request->status_id;
        $car->save();

        return redirect()->route('carlist.index')
            ->with('success', 'แก้ไขข้อมูลรถยนต์สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (RequestCar::where('car_id', $id)->exists()) {
            return back()->with('error', 'ต้องลบคำขอรถยนต์คันนี้ทั้งหมดก่อน');
        }

        Car::destroy($id);

        return back()->with('success', 'ลบรถยนต์สำเร็จ');
    }

    public function findModel(Request $request)
    {

        $data = CarModel::select('name', 'id')->where('brand_id', $request->id)->get();
        return response()->json($data);
    }

    public function addcar()
    {
        //
        if (Auth::user()->permission_id == 2) {
            $departmentcheck = Auth::user()->department_id;
            $department = Department::where('id', $departmentcheck)->get();

        } else {
            $department = Department::all();
        }

        $a = 4;
        $type = Typecar::all();
        $color = Color::all();
        $status = CarStatus::all();
        $brand = Brand::all();

        return view('admin.menucar.addcar', compact('type', 'color', 'status', 'department', 'brand', 'a'));
    }

    public function search(Request $request)
    {
        $a = 4;

        $typecar = Typecar::all();
        $color = Color::all();
        $brand = Brand::all();
        $status = CarStatus::all();
        $department = Department::all();
        $departmentcheck = Auth::user()->department_id;
        // admin

        $search_text = $request->searchname;
        if (Auth::user()->permission_id == 1) {
            if ($request->select == 2) {
                $car = Car::where('active', 1)
                    ->where('regisNumber', 'LIKE', '%' . $search_text . '%')
                    ->paginate(10);

                return view('admin.menucar.carlist', compact('car', 'a', 'typecar', 'color', 'brand', 'status', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            }

            if ($request->select == 3) {
                $department1 = Department::where('name', 'LIKE', '%' . $search_text . '%')
                    ->get()
                    ->pluck('id');

                $car = Car::where('active', 1)
                    ->whereIn('department_id', $department1)
                    ->paginate(10);

                return view('admin.menucar.carlist', compact('car', 'a', 'typecar', 'color', 'brand', 'status', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            }

            if ($request->select == 4) {
                $typecar1 = Typecar::where('name', 'LIKE', '%' . $search_text . '%')
                    ->get()
                    ->pluck('id');

                $car = Car::where('active', 1)
                    ->whereIn('type_id', $typecar1)
                    ->paginate(10);

                return view('admin.menucar.carlist', compact('car', 'a', 'typecar', 'color', 'brand', 'status', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            }

            $car = Car::where('active', 1)
                ->orderBy('department_id', 'asc')
                ->orderBy('type_id', 'asc')
                ->orderBy('capacity', 'asc')
                ->paginate(10);

            return view('admin.menucar.carlist', compact('car', 'a', 'typecar', 'color', 'brand', 'status', 'department'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }
        if (Auth::user()->permission_id == 2) {
            if ($request->select == 2) {
                $car = Car::where('active', 1)
                    ->where('department_id', $departmentcheck)
                    ->where('regisNumber', 'LIKE', '%' . $search_text . '%')
                    ->paginate(10);

                return view('admin.menucar.carlist', compact('car', 'a', 'typecar', 'color', 'brand', 'status', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            }

            if ($request->select == 3) {
                $typecar1 = Typecar::where('name', 'LIKE', '%' . $search_text . '%')
                    ->get()
                    ->pluck('id');

                $car = Car::where('active', 1)
                    ->where('department_id', $departmentcheck)
                    ->whereIn('type_id', $typecar1)
                    ->paginate(10);

                return view('admin.menucar.carlist', compact('car', 'a', 'typecar', 'color', 'brand', 'status', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            }

            $car = Car::where('active', 1)
                ->where('department_id', $departmentcheck)
                ->orderBy('type_id', 'asc')
                ->orderBy('capacity', 'asc')
                ->paginate(10);

            return view('admin.menucar.carlist', compact('car', 'a', 'typecar', 'color', 'brand', 'status', 'department'))
                ->with('i', (request()->input('page', 1) - 1) * 10);

        }

    }

    public function inactive($id)
    {
        //
        if (RequestCar::where('car_id', $id)->whereIn('status_id', [1, 2, 3])->exists()) {
            return redirect()->route('carlist.index')
                ->with('error', 'กรุณายกเลิกคำขอใช้รถของผู้ใช้');
        }

        $car = Car::find($id);
        $car->active = 0;
        $car->save();

        return redirect()->route('carlist.index')
            ->with('success', 'ยกเลิกสิทธิ์สำเร็จ');
    }

}
