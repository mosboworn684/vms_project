<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Permission;
use App\Models\Prefix;
use App\Models\RequestCar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDontActiveController extends Controller
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
            $user = User::where('active', 0)->paginate(9);
            return view('admin.menuuser.userDontactive', compact('user', 'a', 'prefix', 'permission', 'department'))
                ->with('i', (request()->input('page', 1) - 1) * 8);
        }

        if (Auth::user()->permission_id == 2) {
            $departmentcheck = Auth::user()->department_id;
            $department = Department::where('id', $departmentcheck)->get();
            $permission = Permission::where('id', 3)->get();
            $user = User::where('department_id', $departmentcheck)
                ->where('active', 0)->paginate(9);

            return view('admin.menuuser.userDontactive', compact('user', 'a', 'prefix', 'permission', 'department'))
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
        $user = User::find($id);

        $user->active = 1;
        $user->save();

        return redirect()->route('userDontactive.index')
            ->with('success', 'บัญชีที่เลือกเปิดการใช้งานแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (RequestCar::where('user_id', $id)->exists()) {
            return redirect()->route('userDontactive.index')
                ->with('error', 'พนักงานเคยมีข้อมูลการขอใช้รถ กรุณาลบข้อมูลการขอใช้รถยนต์ก่อน');
        }
        User::destroy($id);

        return redirect()->route('userDontactive.index')
            ->with('success', 'ลบพนักงานสำเร็จ');
    }
}
