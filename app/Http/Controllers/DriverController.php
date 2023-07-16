<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Prefix;
use App\Models\RequestCar;
use App\Models\Statusdriver;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = 6;
        $data = Driver::where('active', 1)->get();
        $prefix = Prefix::All();
        $status = Statusdriver::All();

        $requestcar = RequestCar::all();

        $countReqest = Driver::where('drivernumber_id', "like", "%" . 'DV' . "%")->get()->count();

        if ($countReqest != 0) {
            $checkRequestNo = Driver::where('drivernumber_id', "like", "%" . 'DV' . "%")
                ->latest()->first()->drivernumber_id;

            $number = substr($checkRequestNo, 2);
            $drivernumber_id = (int) $number + 1;

            if (strlen($drivernumber_id) == 1) {
                $drivernumberId = "DV00" . $drivernumber_id;
            } else if (strlen($drivernumber_id) == 2) {
                $drivernumberId = "DV0" . $drivernumber_id;
            } else {
                $drivernumberId = "DV" . $drivernumber_id;
            }
        } else {
            $drivernumberId = "DV001";
        }

        if (count($data) == 0) {
            return view('admin.menucar.adddriver', compact('data', 'a', 'prefix', 'status', 'requestcar', 'drivernumberId'));
        }

        $data = Driver::where('active', 1)->paginate(10);

        return view('admin.menucar.adddriver', compact('data', 'a', 'prefix', 'status', 'requestcar', 'drivernumberId'))
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

        $countReqest = Driver::where('drivernumber_id', "like", "%" . 'DV' . "%")->get()->count();

        if ($countReqest != 0) {
            $checkRequestNo = Driver::where('drivernumber_id', "like", "%" . 'DV' . "%")
                ->latest()->first()->drivernumber_id;

            $number = substr($checkRequestNo, 2);
            $drivernumber_id = (int) $number + 1;

            if (strlen($drivernumber_id) == 1) {
                $drivernumberId = "DV00" . $drivernumber_id;
            } else if (strlen($drivernumber_id) == 2) {
                $drivernumberId = "DV0" . $drivernumber_id;
            } else {
                $drivernumberId = "DV" . $drivernumber_id;
            }
        } else {
            $drivernumberId = "DV001";
        }

        $driver = new Driver();

        $driver->birthday = $request->birthday;

        $dateOfBirth = $request->birthday;
        $age = Carbon::parse($dateOfBirth)->age;

        if (($age < 25) || ($age > 50)) {

            return redirect()->route('driver.index')
                ->with('error', 'รับเฉพาะอายุ 25-50 ปีเท่านั้น');

        }

        if (Driver::where('firstname', $request->firstname)
            ->where('lastname', $request->lastname)->exists()) {
            return redirect()->route('driver.index')
                ->with('error', 'ชื่อและนามสกุลนี้มีอยู่แล้ว');
        }
        $driver->prefix_id = $request->prefix_id;

        if (Driver::where('drivernumber', $request->drivernumber)->exists()) {
            return redirect()->route('driver.index')
                ->with('error', 'หมายเลขใบขับขี่ซ้ำ กรุณาตรวจสอบ');
        }

        $driver->drivernumber = $request->drivernumber;
        $driver->firstname = $request->firstname;
        $driver->lastname = $request->lastname;

        if (Driver::where('tel', $request->tel)->exists()) {
            return redirect()->route('driver.index')
                ->with('error', 'เบอร์โทรศัพท์นี้มีคนใช้อยู่แล้ว');
        }

        $driver->tel = $request->tel;

        if (Driver::where('drivernumber_id', $request->drivernumber_id)->exists()) {
            return redirect()->route('driver.index')
                ->with('error', 'รหัสพนักงานขับรถซ้ำ กรุณาตรวจสอบ');
        }

        $driver->drivernumber_id = $drivernumberId;
        $driver->status_id = 1;

        $driver->save();

        return redirect()->route('driver.index')
            ->with('success', 'เพิ่มพนักงานขับรถสำเร็จ');
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
        $begin = $request->starttime;
        $end = $request->endtime;

        $driver = Driver::find($id);

        $driver->firstname = $request->firstname;
        $driver->lastname = $request->lastname;

        if (Driver::where('tel', $request->tel)->whereNotIn('id', [$id])->exists()) {
            return redirect()->route('driver.index')
                ->with('error', 'เบอร์โทรศัพท์นี้มีคนใช้อยู่แล้ว');
        }

        if ($request->status_id == 2) {
            $checkwork = RequestCar::where('driver_id', $id)
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

            if ($checkwork != 0) {
                return redirect()->route('driver.index')
                    ->with('error', 'ไม่สามารถลาได้เนื่องจากมีงานวันที่ต้องการลา');
            }
        }

        $driver->tel = $request->tel;
        $driver->status_id = $request->status_id;
        $driver->starttime = $request->starttime;
        $driver->endtime = $request->endtime;
        $driver->save();

        return redirect()->route('driver.index')
            ->with('success', 'แก้ไขข้อมูลพนักงานขับรถสำเร็จ');
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
        if (RequestCar::where('driver_id', $id)->exists()) {
            return back()->with('error', 'ต้องลบคำขอพนักงานขับรถคนนี้ทั้งหมดก่อน');
        }
        Driver::destroy($id);

        return redirect()->route('driver.index')
            ->with('success', 'ลบพนักงานขับรถสำเร็จ');
    }

    public function inactive($id)
    {
        //
        if (RequestCar::where('driver_id', $id)->whereIn('status_id', [1, 2, 3])->exists()) {
            return redirect()->route('userlist.index')
                ->with('error', 'กรุณายกเลิกคำขอใช้รถของผู้ใช้');
        }

        $driver = Driver::find($id);
        $driver->active = 0;
        $driver->save();

        return redirect()->route('driver.index')
            ->with('success', 'ยกเลิกสิทธิ์สำเร็จ');
    }
}
