<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Permission;
use App\Models\Prefix;
use App\Models\RequestCar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = 11;
        $departmentcheck = Auth::user()->department_id;
        $prefix = Prefix::All();
        $permission = Permission::all();
        $department = Department::all();

        if (Auth::user()->permission_id == 1) {
            $user = User::where('active', 1)
                ->paginate(9);

            return view('admin.menuuser.userlist', compact('user', 'a', 'prefix', 'permission', 'department'))
                ->with('i', (request()->input('page', 1) - 1) * 8);
        }

        if (Auth::user()->permission_id == 2) {

            $countReqest = User::where('employeenumber', "like", "%" . Auth::user()->department->code . "%")->get()->count();

            if ($countReqest != 0) {
                $checkRequestNo = User::where('employeenumber', "like", "%" . Auth::user()->department->code . "%")
                    ->latest()->first()->employeenumber;

                $number = substr($checkRequestNo, 2);
                $request_No = (int) $number + 1;

                if (strlen($request_No) == 1) {
                    $requestNo = Auth::user()->department->code . "00" . $request_No;
                } else if (strlen($request_No) == 2) {
                    $requestNo = Auth::user()->department->code . "0" . $request_No;
                } else {
                    $requestNo = Auth::user()->department->code . $request_No;
                }
            } else {
                $requestNo = Auth::user()->department->code . "001";
            }

            $departmentcheck = Auth::user()->department_id;

            $department = Department::where('id', $departmentcheck)
                ->get();
            $permission = Permission::where('id', 3)
                ->get();

            $user = User::where('department_id', $departmentcheck)
                ->where('active', 1)
                ->paginate(9);

            return view('admin.menuuser.userlist', compact('user', 'a', 'prefix', 'permission', 'department', 'requestNo'))
                ->with('i', (request()->input('page', 1) - 1) * 8);
        }

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
        $a = 11;
        $user = User::where('id', $id)->get();

        return view('admin.menuuser.edituser', compact('a', 'user'));
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
        $request = $request->except(['_token', '_method']);

        User::where('id', $id)->update($request);

        return redirect()->route('userlist.index')
            ->with('success', 'แก้ไขพนักงานสำเร็จ');
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

    public function editprofile($id)
    {
        //
        $a = 11;
        $user = User::where('id', $id)->get();

        return view('admin.menuuser.edituser', compact('a', 'user'));
    }

    public function updateprofile(Request $request, $id)
    {
        //
        $request = $request->except(['_token', '_method']);

        User::where('id', $id)->update($request);

        return redirect()->route('userlist.index')
            ->with('success', 'แก้ไขพนักงานสำเร็จ');
    }

    public function inactive($id)
    {
        //
        if (RequestCar::where('user_id', $id)->whereIn('status_id', [1, 2, 3])->exists()) {
            return redirect()->route('userlist.index')
                ->with('error', 'กรุณายกเลิกคำขอใช้รถของผู้ใช้');
        }

        $user = User::find($id);
        $user->active = 0;
        $user->save();

        return redirect()->route('userlist.index')
            ->with('success', 'ยกเลิกสิทธิ์สำเร็จ');
    }

    public function search(Request $request)
    {
        $a = 11;
        $departmentcheck = Auth::user()->department_id;
        $prefix = Prefix::All();
        $permission = Permission::all();
        $department = Department::all();
        // admin

        $search_text = $request->searchname;
        if (Auth::user()->permission_id == 1) {
            if ($request->select == 2) {
                $user = User::where('employeenumber', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->paginate(9);

                return view('admin.menuuser.userlist', compact('user', 'a', 'prefix', 'permission', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 8);
            }

            if ($request->select == 3) {
                $user = User::where('firstname', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->orwhere('lastname', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->paginate(9);

                return view('admin.menuuser.userlist', compact('user', 'a', 'prefix', 'permission', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 8);
            }

            if ($request->select == 4) {
                $user = User::where('tel', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->paginate(9);

                return view('admin.menuuser.userlist', compact('user', 'a', 'prefix', 'permission', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 8);
            }

            if ($request->select == 5) {
                $department1 = Department::where('name', 'LIKE', '%' . $search_text . '%')
                    ->get()
                    ->pluck('id');

                $user = User::whereIn('department_id', $department1)
                    ->where('active', 1)
                    ->paginate(9);

                return view('admin.menuuser.userlist', compact('user', 'a', 'prefix', 'permission', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 8);
            }

            $user = User::where('active', 1)->paginate(9);

            return view('admin.menuuser.userlist', compact('user', 'a', 'prefix', 'permission', 'department'))
                ->with('i', (request()->input('page', 1) - 1) * 8);
        }

        if (Auth::user()->permission_id == 2) {
            $department = Department::where('id', $departmentcheck)
                ->get();

            if ($request->select == 2) {
                $user = User::where('employeenumber', 'LIKE', '%' . $search_text . '%')
                    ->where('department_id', $departmentcheck)
                    ->where('active', 1)
                    ->paginate(9);

                return view('admin.menuuser.userlist', compact('user', 'a', 'prefix', 'permission', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 8);
            }

            if ($request->select == 3) {
                $user = User::where('firstname', 'LIKE', '%' . $search_text . '%')
                    ->where('department_id', $departmentcheck)
                    ->where('active', 1)
                    ->orwhere('lastname', 'LIKE', '%' . $search_text . '%')
                    ->where('department_id', $departmentcheck)
                    ->where('active', 1)
                    ->paginate(9);

                return view('admin.menuuser.userlist', compact('user', 'a', 'prefix', 'permission', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 8);
            }

            if ($request->select == 4) {
                $user = User::where('tel', 'LIKE', '%' . $search_text . '%')
                    ->where('department_id', $departmentcheck)
                    ->where('active', 1)
                    ->paginate(9);

                return view('admin.menuuser.userlist', compact('user', 'a', 'prefix', 'permission', 'department'))
                    ->with('i', (request()->input('page', 1) - 1) * 8);
            }

            $user = User::where('active', 1)
                ->where('department_id', $departmentcheck)
                ->paginate(9);

            return view('admin.menuuser.userlist', compact('user', 'a', 'prefix', 'permission', 'department'))
                ->with('i', (request()->input('page', 1) - 1) * 8);
        }
    }
}
