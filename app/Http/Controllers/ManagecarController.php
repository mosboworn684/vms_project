<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\RequestCar;
use App\Models\User;
use App\Notifications\SendEmailNotification;
use App\Services\ThaiDateHelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ManagecarController extends Controller
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

        if (Auth::user()->permission_id == 1) {
            $car = Car::all();
            if (count($car) == 0) {

                return view('user.managecar', compact('car', 'a'));
            }

            $car = Car::first()->paginate(10);
            return view('user.managecar', compact('car', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }

        $car = Car::all();
        if (count($car) == 0) {

            return view('user.managecar', compact('car', 'a'));
        }

        $car = Car::where('department_id', $departmentcheck)->paginate(10);
        // $record = RequestCar::where('type_id' )->paginate(5);
        return view('user.managecar', compact('car', 'a'))
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
     * @param  int  $car_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

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

    public function updatetest(Request $request, $carid, $reqeustid, ThaiDateHelperService $thaidate)
    {

        $car = Car::find($carid);
        $managecar = RequestCar::find($reqeustid);
        $begin = $managecar->startTime;
        $end = $managecar->endTime;

        $checkcar = RequestCar::where('car_id', $carid)
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

        if ($checkcar != 0) {
            return "รถยนต์คันนี้ถูกขอใช้แล้วในช่วงเวลานี้";
        }

        $managecar->first_mileage = $car->mileage;
        $managecar->car_id = $carid; //
        $managecar->status_set_id = 2; // อัพเดทเป็นจัดรถแล้ว
        if (($managecar->status_set_id == 2 && $managecar->want_driver == 2) ||
            ($managecar->status_set_id == 2 && $managecar->want_driver == 0)) {

            $user = User::where('id', $managecar->user_id)->first();

            $details = [
                'subject' => 'Vehicle Management System',
                'greeting' => 'เลขที่ขอใช้รถยนต์ ' . $managecar->requestNo . ' ของคุณได้รับการจัดรถยนต์แล้ว',
                'body' => 'วันที่ใช้รถยนต์  ' . $thaidate->simpleDate($begin) . '-' . $thaidate->simpleDate($end) .
                'สถานที่ไป : ' . $managecar->location,
                'actiontext' => 'กดคลิกเพื่อเข้าสู่ระบบ',
                'actionurl' => 'http://127.0.0.1:8000/login',
                'lastline' => 'หากใช้งานรถยนต์เสร็จสิ้นกรุณากดคืนรถยนต์',
            ];

            Notification::send($user, new SendEmailNotification($details));

            $managecar->status_id = 3;
        }
        $managecar->save();
        $car->save();

        return redirect()->route('carset.index')
            ->with('success', 'จัดรถยนต์สำเร็จ');
    }
}
