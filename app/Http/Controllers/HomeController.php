<?php

namespace App\Http\Controllers;

use App\Models\RequestCar;
use App\Models\User;
use App\Notifications\SendEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    public function index()
    {
        $a = 90;
        if (Auth::user()->permission_id == 2) {
            // สถานะรออนุมัติ
            $approve = RequestCar::where('department_car', Auth::user()->department_id)->where('status_id', 1)->get();
            $count_approve = count($approve);
            //

            // สถานะรอจัดรถ
            $manage = RequestCar::where('department_car', Auth::user()->department_id)->where('status_id', 2)->get();
            $count_manage = count($manage);
            //

            //สถานะรอคืนรถ
            $returncar = RequestCar::where('department_car', Auth::user()->department_id)->where('status_id', 3)->get();
            $count_returncar = count($returncar);
            //
            return view('home.index', compact('a', 'count_approve', 'count_manage', 'count_returncar'));
        }

        $approve = RequestCar::where('status_id', 1)->get();
        $count_approve = count($approve);

        $manage = RequestCar::where('status_id', 2)->get();
        $count_manage = count($manage);

        $returncar = RequestCar::where('status_id', 3)->get();
        $count_returncar = count($returncar);

        return view('home.index', compact('a', 'count_approve', 'count_manage', 'count_returncar'));
    }

    public function updatepassword(Request $request, $id)
    {
        //
        // $request = $request->except(['_token', '_method']);

        if ($request->password != $request->confirm) {
            return printf('ใส่รหัสผ่านผิด');
        }

        $user = User::find($id);

        $user->password = $request->password;
        $user->save();

        return back();
    }

    public function sendnotification()
    {
        $user = User::all();

        $details = [
            'subject' => 'Vehicle Management System',
            'greeting' => 'คำขอของคุณได้รับการจัดรถยนต์แล้ว',
            'body' => 'เข้าสู่ระบบเพื่อดูรายละเอียดข้อมูล',
            'actiontext' => 'กดคลิกเพื่อเข้าสู่ระบบ',
            'actionurl' => 'http://127.0.0.1:8000/login',
            'lastline' => 'หากใช้งานรถยนต์เสร็จสิ้นกรุณากดคืนรถยนต์',
        ];

        Notification::send($user, new SendEmailNotification($details));

        dd('done');
    }
}
