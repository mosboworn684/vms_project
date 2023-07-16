<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use App\Models\RequestCar;
use App\Models\Typecar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $a = 91;
        $type = Typecar::all();
        $data = RequestCar::whereNotIn('status_id', [4])
            ->orderBy('department_car', 'asc')
            ->paginate(10);
        $departmentcheck = Auth::user()->department_id;
        $datetime = date("Y-m-d H:i:s");

        if (Auth::user()->permission_id == 3) {
            $data = RequestCar::where('user_id', Auth::user()->id)
                ->whereNotIn('status_id', [4])
                ->orderBy('department_car', 'asc')
                ->paginate(10);

            return view('user.recordRequest', compact('data', 'a', 'type', 'datetime'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }

        if (Auth::user()->permission_id == 2) {
            $data = RequestCar::where('department_car', $departmentcheck)
                ->whereNotIn('status_id', [4])
                ->paginate(10);

            return view('user.recordRequest', compact('data', 'a', 'type', 'datetime'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }

        if (count($data) == 0) {
            return view('user.recordRequest', compact('data', 'a', 'type', 'datetime'));
        }

        return view('user.recordRequest', compact('data', 'a', 'type', 'datetime'))
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
        $countReqest = RequestCar::where('requestNo', "like", "%" . Auth::user()->department->code . "%")->get()->count();

        if ($countReqest != 0) {
            $checkRequestNo = RequestCar::where('requestNo', "like", "%" . Auth::user()->department->code . "%")
                ->latest()->first()->requestNo;

            $number = substr($checkRequestNo, 3);
            $request_No = (int) $number + 1;

            if (strlen($request_No) == 1) {
                $requestNo = Auth::user()->department->code . "R00" . $request_No;
            } else if (strlen($request_No) == 2) {
                $requestNo = Auth::user()->department->code . "R0" . $request_No;
            } else {
                $requestNo = Auth::user()->department->code . "R" . $request_No;
            }
        } else {
            $requestNo = Auth::user()->department->code . "R001";
        }

        $begin = $request->startTime;
        $end = $request->endTime;

        $checkRequest = RequestCar::where('user_id', Auth::user()->id) // probably scoping to a single user??
            ->where(function ($query) use ($begin, $end) {
                $query->where(function ($q) use ($begin, $end) {
                    $q->where('startTime', '>=', $begin)
                        ->where('startTime', '<', $end);
                })->orWhere(function ($q) use ($begin, $end) {
                    $q->where('startTime', '<=', $begin)
                        ->where('endTime', '>', $end);
                })->orWhere(function ($q) use ($begin, $end) {
                    $q->where('endTime', '>', $begin)
                        ->where('endTime', '<=', $end);
                })->orWhere(function ($q) use ($begin, $end) {
                    $q->where('startTime', '>=', $begin)
                        ->where('endTime', '<=', $end);
                });
            })->count();

        if ($request->passenger < 1) {
            return redirect()->route('recordRequest.index')
                ->with('errorunit', 'กรุณาใส่จำนวนที่ถูกต้อง')->withInput();
        }

        if ($request->startTime < $request->checktime || $request->endTime <= $request->startTime) {
            return redirect()->route('recordRequest.index')
                ->with('errordate', 'กรุณาตรวจสอบวัน/เวลาให้ถูกต้อง')->withInput();
        }

        //เช็คห้ามขอใช้รถซ้ำในวันที่เคยจอง
        if ($checkRequest != 0) {
            return back()
                ->with('errordate1', 'คุณมีรายการขอใช้รถยนต์ช่วงเวลานี้แล้ว')->withInput();
        }
        $record = new RequestCar;

        $record->requestNo = $requestNo;
        $record->user_id = $request->user_id;
        $record->startTime = $request->startTime;
        $record->endTime = $request->endTime;
        $record->location = $request->location;
        $record->type_id = $request->type_id;
        $record->status_set_id = 1;
        $record->detail = $request->detail;
        $record->status_id = $request->status_id;
        $record->department_car = $request->department_car;
        $record->want_driver = isset($request->want_driver) ? $request->want_driver : 0;

        // if ($request->want_driver == 1) {
        //     $record->passenger = $request->passenger + 1;
        // } else {
        //     $record->passenger = $request->passenger;
        // }
        $record->passenger = $request->passenger;
        $record->current_mileage = $request->current_mileage;
        $record->first_mileage = $request->first_mileage;
        $record->run_mileage = $request->run_mileage;
        $record->price_oil = $request->price_oil;
        $record->slip_oil = $request->slip_oil;
        $record->save();

        return redirect()->route('recordRequest.index')
            ->with('success', 'ขอใช้รถยนต์สำเร็จ');
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

        $a = 93;
        $carset = RequestCar::find($id);
        // return $carset;
        $requestcar = RequestCar::all();
        $begin = $carset->startTime;
        $end = $carset->endTime;

        $checkcar = RequestCar::whereNotin('id', [$id])
            ->where('department_car', $carset->department_car)
            ->where(function ($query) use ($begin, $end) {
                $query->where(function ($q) use ($begin, $end) {
                    $q->where('startTime', '>=', $begin)
                        ->where('startTime', '<', $end);
                })->orWhere(function ($q) use ($begin, $end) {
                    $q->where('startTime', '<=', $begin)
                        ->where('endTime', '>', $end);
                })->orWhere(function ($q) use ($begin, $end) {
                    $q->where('endTime', '>', $begin)
                        ->where('endTime', '<=', $end);
                })->orWhere(function ($q) use ($begin, $end) {
                    $q->where('startTime', '>=', $begin)
                        ->where('endTime', '<=', $end);
                });
            })->whereNotNull('car_id')->get()->pluck('car_id');

        $typecar = RequestCar::where('id', $id)->first()->type_id;
        $department = RequestCar::where('id', $id)->first()->department_car;

        if ($carset->want_driver != 0) {
            $passenger = $carset->passenger + 1;
        } else {
            $passenger = $carset->passenger;
        }

        $car = Car::whereNotin('id', $checkcar)
            ->whereNotin('id', [$carset->car_id])
            ->where('type_id', $typecar)
            ->where('department_id', $department)
            ->where('status_id', 1)
            ->where('active', 1)
            ->where('capacity', '>=', $passenger)
            ->orderBy('capacity', 'asc')
            ->get();

        return view('user.changecar', compact('a', 'carset', 'car', 'checkcar', 'requestcar', 'begin'))->with('i', (request()->input('page', 1) - 1) * 10);
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

        $return_car = RequestCar::find($id);
        // return $return_car;
        $end = $return_car->endTime;
        $date = Carbon::create($end)->addDays(2);
        $checkdate = $date->format('Y-m-d');
        $datenow = date('Y-m-d');

        if ($datenow > $checkdate) {
            $status_return = 1;
        } else {
            $status_return = 0;
        }

        $car = Car::find($return_car->car_id);
        $driver = Driver::find($return_car->driver_id);

        if ($request->current_mileage < $request->first_mileage) {
            return redirect()->route('recordRequest.index')
                ->with('errormileage', 'กรุณาใส่จำนวนเลขไมล์ให้ถูกต้อง');
        }

        $return_car->current_mileage = $request->current_mileage;
        $return_car->run_mileage = $return_car->current_mileage - $return_car->cars->mileage; //ไมล์ที่ใช้วิ่ง
        $return_car->price_oil = $request->price_oil;

        if ($request->hasfile('slip_oil')) {
            foreach ($request->file('slip_oil') as $file) {
                $name = $file->getClientOriginalName();
                $file->storeAs('public/images/', $name);
                $data[] = $name;
            }
            $return_car->slip_oil = implode(',', $data);
        }

        // return $data;
        //   return $return_car->slip_oil;
        //   return explode(',', $return_car->slip_oil);
        // $return_car->slip_oil = str_replace(array("[","]"),'',$data);

        // return $request->file('slip_oil');
        // $name = $request->file('slip_oil')->getClientOriginalName();

        // $request->file('slip_oil')->storeAs('public/images/', $name);

        // $return_car->slip_oil = $name;

        // $return_car->slip_oil = str_replace(array("[","]"),'',$data);
        $return_car->status_id = 4; //ตั้งสถานะว่าคืนรถแล้ว
        $return_car->returndetail = $request->returndetail;
        $return_car->returnTime = date('Y-m-d H:i:s');
        $return_car->status_return = $status_return;
        $car->mileage = $return_car->current_mileage;
        $car->status_id = 1; //ตั้งสถานะของรถเป็นว่าง

        if ($return_car->want_driver != 0) {
            $driver->status_id = 1; //ตั้งสถานะของพนักงานขับรถเป็นว่าง
            $driver->save();
        }

        $car->save();
        $return_car->save();

        return redirect()->route('returncar.index')
            ->with('successreturn', 'คืนรถสำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RequestCar::destroy($id);

        return redirect()->route('recordRequest.index')
            ->with('success', 'ลบคำขอใช้รถยนต์สำเร็จ');
        //
    }

    public function updatereturncar(Request $request, $id)
    {
    }
}
