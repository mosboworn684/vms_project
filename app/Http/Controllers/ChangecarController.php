<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\RequestCar;
use App\Models\User;
use App\Notifications\SendEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ChangecarController extends Controller
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
    public function changecar(Request $request, $carid, $reqeustid)
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
        //
        $managecar->status_set_id = 2; // อัพเดทเป็นจัดรถแล้ว
        if (($managecar->status_set_id == 2 && $managecar->want_driver == 2) ||
            ($managecar->status_set_id == 2 && $managecar->want_driver == 0)) {

            $user = User::where('id', $managecar->user_id)->first();

            $details = [
                'subject' => 'Vehicle Management System',
                'greeting' => 'เลขที่ขอใช้รถยนต์ ' . $managecar->requestNo . ' ของคุณได้มีการเปลี่ยนแปลงรถยนต์',
                'body' => 'รถยนต์เดิม เลขทะเบียน : ' . $managecar->cars->regisNumber . ' ยี่ห้อ : ' . $managecar->cars->brands->name .
                ' รุ่น : ' . $managecar->cars->models->name . ' สี : ' . $managecar->cars->colors->name .

                ' เปลี่ยนรถยนต์ใหม่ เลขทะเบียน : ' . $car->regisNumber . ' ยี่ห้อ : ' . $car->brands->name .
                ' รุ่น : ' . $car->models->name . ' สี : ' . $car->colors->name,

                'actiontext' => 'กดคลิกเพื่อเข้าสู่ระบบ',
                'actionurl' => 'http://127.0.0.1:8000/login',
                'lastline' => 'เหตุผลที่เปลี่ยนรถ : ' . $request->detail,
            ];

            Notification::send($user, new SendEmailNotification($details));

            $managecar->status_id = 3;
        }

        $managecar->car_id = $carid;
        $managecar->save();
        $car->save();

        return redirect()->route('recordRequest.index')
            ->with('success', 'เปลี่ยนรถยนต์สำเร็จ');
    }
}
