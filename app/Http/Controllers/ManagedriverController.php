<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Prefix;
use App\Models\RequestCar;
use App\Models\Statusdriver;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\SendEmailNotification;
use App\Services\ThaiDateHelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ManagedriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = 93;
        $data = Driver::All();
        $prefix = Prefix::All();
        $status = Statusdriver::All();

        if (count($data) == 0) {

            return view('user.managedriver', compact('data', 'a', 'prefix', 'status'));
        }
        $data = Driver::first()->paginate(10);
        return view('user.managedriver', compact('data', 'a', 'prefix', 'status'))
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
    public function update(Request $request, $requestid, $driverid)
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
    public function updatedriver(Request $request, $driverid, $requestid, ThaiDateHelperService $thaidate)
    {
        $driver = Driver::find($driverid);
        $managedriver = RequestCar::find($requestid);
        $begin = $managedriver->startTime;
        $end = $managedriver->endTime;
        $datebegin = Carbon::create($begin)->toDateString();
        $dateend = Carbon::create($end)->toDateString();

        $checkdriver = RequestCar::where('driver_id', $driverid)
            ->where(function ($query) use ($datebegin, $dateend) {
                $query->where(function ($q) use ($datebegin, $dateend) {
                    $q->where('startTime', '>=', $datebegin)
                        ->where('startTime', '<', $dateend);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->where('startTime', '<=', $datebegin)
                        ->where('endTime', '>', $dateend);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->where('endTime', '>', $datebegin)
                        ->where('endTime', '<=', $dateend);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->where('startTime', '>=', $datebegin)
                        ->where('endTime', '<=', $dateend);
                });
            })->count();

        if ($checkdriver != 0) {
            return "รถยนต์คันนี้ถูกขอใช้แล้วในช่วงเวลานี้";
        }

        $managedriver->driver_id = $driverid; //
        $managedriver->want_driver = 2; // อัพเดทเป็นจัดคนขับแล้ว

        if (($managedriver->status_set_id == 2 && $managedriver->want_driver == 2) ||
            ($managedriver->status_set_id == 2 && $managedriver->want_driver == 0)) {

            $user = User::where('id', $managedriver->user_id)->first();

            $details = [
                'subject' => 'Vehicle Management System',
                'greeting' => 'เลขที่ขอใช้รถยนต์ ' . $managedriver->requestNo . ' ของคุณได้รับการจัดรถยนต์แล้ว',
                'body' => 'วันที่ใช้รถยนต์  ' . $thaidate->simpleDate($begin) . '-' . $thaidate->simpleDate($end) .
                'สถานที่ไป : ' . $managedriver->location,
                'actiontext' => 'กดคลิกเพื่อเข้าสู่ระบบ',
                'actionurl' => 'http://127.0.0.1:8000/login',
                'lastline' => 'หากใช้งานรถยนต์เสร็จสิ้นกรุณากดคืนรถยนต์',
            ];

            Notification::send($user, new SendEmailNotification($details));

            $managedriver->status_id = 3;
        }
        $managedriver->save();
        $driver->save();

        return redirect()->route('carset.index')
            ->with('success', 'จัดพนักงานขับรถสำเร็จ');
    }
}
