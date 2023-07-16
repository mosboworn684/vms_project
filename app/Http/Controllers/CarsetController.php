<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use App\Models\RequestCar;
use App\Models\User;
use App\Notifications\SendEmailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CarsetController extends Controller
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
        $carset = RequestCar::All();

        if (Auth::user()->permission_id == 1) {
            $carset = RequestCar::where('status_id', 2)
                ->orderBy('department_car', 'asc')
                ->paginate(10);

            if (count($carset) == 0) {
                return view('user.carset', compact('carset', 'a', ));
            }

            return view('user.carset', compact('carset', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }

        $carset = RequestCar::where('department_car', $departmentcheck)
            ->where('status_id', 2)
            ->paginate(10);

        if (count($carset) == 0) {
            return view('user.carset', compact('carset', 'a'));
        }

        return view('user.carset', compact('carset', 'a'))
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

        $a = 93;
        $carset = RequestCar::find($id);
        $requestcar = RequestCar::all();
        $begin = $carset->startTime;
        $end = $carset->endTime;

        $datebegin = Carbon::create($begin)->toDateString();
        $dateend = Carbon::create($end)->toDateString();

        $DateE = Carbon::create($end)->addHours(2);
        $DateB = Carbon::create($begin)->subHours(2);
        $datebegin2 = $DateB->format('Y-m-d H:i:s');
        $dateend2 = $DateE->format('Y-m-d H:i:s');

        $checkcar = RequestCar::whereNotin('id', [$id])
            ->where('department_car', $carset->department_car)
            ->where(function ($query) use ($datebegin2, $dateend2) {
                $query->where(function ($q) use ($datebegin2, $dateend2) {
                    $q->where('startTime', '>=', $datebegin2)
                        ->where('startTime', '<', $dateend2);
                })->orWhere(function ($q) use ($datebegin2, $dateend2) {
                    $q->where('startTime', '<=', $datebegin2)
                        ->where('endTime', '>', $dateend2);
                })->orWhere(function ($q) use ($datebegin2, $dateend2) {
                    $q->where('endTime', '>', $datebegin2)
                        ->where('endTime', '<=', $dateend2);
                })->orWhere(function ($q) use ($datebegin2, $dateend2) {
                    $q->where('startTime', '>=', $datebegin2)
                        ->where('endTime', '<=', $dateend2);
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
            ->where('active', 1)
            ->where('type_id', $typecar)
            ->where('department_id', $department)
            ->where('status_id', 1)
            ->where('capacity', '>=', $passenger)
            ->orderBy('capacity', 'asc')
            ->get();

        return view('user.managecar', compact('a', 'carset', 'car', 'checkcar', 'requestcar', 'begin'))->with('i', (request()->input('page', 1) - 1) * 10);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $userId = RequestCar::where('id', $id)->first();
        $user = User::where('id', $userId->user_id)->first();

        $details = [
            'subject' => 'Vehicle Management System',
            'greeting' => 'คำขอของคุณไม่ได้รับการจัดรถยนต์',
            'body' => 'เข้าสู่ระบบเพื่อขอใช้รถใหม่อีกครั้ง',
            'actiontext' => 'กดคลิกเพื่อเข้าสู่ระบบ',
            'actionurl' => 'http://127.0.0.1:8000/login',
            'lastline' => $request->detail,
        ];

        Notification::send($user, new SendEmailNotification($details));

        RequestCar::destroy($id);
        return redirect()->route('carset.index')
            ->with('success', 'ลบคำขอใช้รถยนต์สำเร็จ');
    }
    public function updatedriver(Request $request, $id)
    {
        $record_approve = RequestCar::find($id);

        $record_approve->want_driver = 2;
        if (($record_approve->status_set_id == 2 && $record_approve->want_driver == 2) ||
            ($record_approve->status_set_id == 2 && $record_approve->want_driver == 0)
        ) {
            $record_approve->status_id = 3;
        }
        $record_approve->save();

        return back();
    }

    public function editdriver($id)
    {

        $a = 93;
        $carset = RequestCar::find($id);
        $requestcar = RequestCar::all();
        $begin = $carset->startTime;
        $end = $carset->endTime;
        $datebegin = Carbon::create($begin)->toDateString();
        $dateend = Carbon::create($end)->toDateString();
        //ต้นฉบับ
        $checkdriver = RequestCar::whereNotin('id', [$id])
            ->where(function ($query) use ($datebegin, $dateend) {
                $query->where(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('startTime', '>=', $datebegin)
                        ->whereDate('startTime', '<', $dateend);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('startTime', '<=', $datebegin)
                        ->whereDate('endTime', '>', $dateend);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('endTime', '>', $datebegin)
                        ->whereDate('endTime', '<=', $dateend);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('startTime', '>=', $datebegin)
                        ->whereDate('endTime', '<=', $dateend);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('endTime', '>=', $datebegin);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('startTime', '=', $dateend);
                });
            })->whereNotNull('driver_id')->get()->pluck('driver_id');

        $checkstatus = Driver::whereNotin('id', $checkdriver)
            ->where('active', 1)
            ->where(function ($query) use ($datebegin, $dateend) {
                $query->where(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('startTime', '>=', $datebegin)
                        ->whereDate('startTime', '<', $dateend);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('startTime', '<=', $datebegin)
                        ->whereDate('endTime', '>', $dateend);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('endTime', '>', $datebegin)
                        ->whereDate('endTime', '<=', $dateend);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('startTime', '>=', $datebegin)
                        ->whereDate('endTime', '<=', $dateend);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('endTime', '=', $datebegin);
                })->orWhere(function ($q) use ($datebegin, $dateend) {
                    $q->whereDate('startTime', '=', $dateend);
                });
            })->get()->pluck('id');

        $driver = Driver::whereNotin('id', $checkstatus)
            ->whereNotin('id', $checkdriver)
            ->where('active', 1)
            ->get();

        return view('user.managedriver', compact('a', 'carset', 'driver', 'checkdriver', 'requestcar', 'begin'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
