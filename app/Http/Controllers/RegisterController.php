<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Department;
use App\Models\Permission;
use App\Models\Prefix;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Display register page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (Auth::user()->permission_id == 2) {
            $departmentcheck = Auth::user()->department_id;
            $department = Department::where('id', $departmentcheck)->get();
            $permission = Permission::where('id', 3)->get();
        } else if (Auth::user()->permission_id == 1) {
            $department = Department::all();
            $permission = Permission::all();

        }
        $prefix = Prefix::All();

        return view('admin.menuuser.register', compact('department', 'permission', 'prefix'));
    }

    /**
     * Handle account registration request
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $code = Department::where('id', $request->department_id)->first()->code;

        $countReqest = User::where('employeenumber', "like", "%" . $code . "%")->get()->count();

        if ($countReqest != 0) {
            $checkRequestNo = User::where('employeenumber', "like", "%" . $code . "%")
                ->latest()->first()->employeenumber;

            $number = substr($checkRequestNo, 2);
            $request_No = (int) $number + 1;

            if (strlen($request_No) == 1) {
                $requestNo = $code . "00" . $request_No;
            } else if (strlen($request_No) == 2) {
                $requestNo = $code . "0" . $request_No;
            } else {
                $requestNo = $code . $request_No;
            }
        } else {
            $requestNo = $code . "001";
        }

        // User::create($request->validated());
        $request->validate([
            'email' => 'required|email:rfc,dns|unique:users,email',
        ]);

        $user = new User();

        if (User::where('firstname', $request->firstname)
            ->where('lastname', $request->lastname)->exists()) {
            return redirect()->route('userlist.index')
                ->with('error', 'ชื่อและนามสกุลนี้มีอยู่แล้ว');
        }

        if (User::where('employeenumber', $request->employeenumber)
            ->exists()) {
            return redirect()->route('userlist.index')
                ->with('error', 'รหัสพนักงานนี้มีอยู่แล้ว');
        }

        if (User::where('tel', $request->tel)->exists()) {
            return redirect()->route('userlist.index')
                ->with('error', 'เบอร์โทรศัพท์นี้มีคนใช้อยู่แล้ว');
        }

        if (User::where('username', $request->username)->exists()) {
            return redirect()->route('userlist.index')
                ->with('error', 'username ซ้ำโปรดตั้งใหม่อีกครั้ง');
        }

        $user->prefix_id = $request->prefix_id;
        $user->employeenumber = $requestNo;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->tel = $request->tel;
        $user->email = $request->email;
        $user->username = $requestNo;
        $user->password = $request->password;
        $user->permission_id = $request->permission_id;
        $user->department_id = $request->department_id;
        $user->active = 1;

        $user->save();

        // auth()->login($user);

        return redirect('/userlist')->with('success', "เพิ่มพนักงานเสร็จสิ้น");
    }
}
