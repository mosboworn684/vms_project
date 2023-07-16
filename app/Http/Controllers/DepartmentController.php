<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = 12;
        $data = Department::all();

        if (count($data) == 0) {

            return view('admin.menuuser.adddepartment', compact('data', 'a'));
        }

        $data = Department::first()->paginate(10);

        return view('admin.menuuser.adddepartment', compact('data', 'a'))
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
        $department = new Department();

        if (Department::where('name', $request->name)->exists()) {
            return redirect()->route('department.index')
                ->with('error', 'มีแผนกนี้อยู่แล้ว');
        }
        if (Department::where('code', $request->code)->exists()) {
            return redirect()->route('department.index')
                ->with('error', 'มีรหัสแผนกนี้อยู่แล้ว');
        }

        $department->code = $request->code;
        $department->name = $request->name;
        $department->save();

        return redirect()->route('department.index')
            ->with('success', 'เพิ่มแผนกสำเร็จ');
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
        $department = Department::find($id);

        if (Department::where('name', $request->name)->exists()) {
            return redirect()->route('department.index')
                ->with('error', 'มีแผนกนี้อยู่แล้ว');
        }
        if (Department::where('code', $request->code)->whereNotIn('id', [$id])->exists()) {
            return redirect()->route('department.index')
                ->with('error', 'มีรหัสแผนกนี้อยู่แล้ว');
        }

        if (Car::where('department_id', $id)->exists()) {
            return redirect()->route('department.index')
                ->with('error', 'มีรถยนต์ที่ใช้แผนกนี้อยู่');
        }

        if (User::where('department_id', $id)->exists()) {
            return redirect()->route('department.index')
                ->with('error', 'มีพนักงานที่ใช้แผนกนี้อยู่');
        }

        $department->code = $request->code;
        $department->name = $request->name;
        $department->save();

        return redirect()->route('department.index')
            ->with('success', 'แก้ไขแผนกสำเร็จ');
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
        if (Car::where('department_id', $id)->exists()) {
            return redirect()->route('department.index')
                ->with('error', 'ต้องลบรถแผนกนี้ทั้งหมดก่อน');
        }

        if (User::where('department_id', $id)->exists()) {
            return redirect()->route('department.index')
                ->with('error', 'ต้องลบพนักงานแผนกนี้ทั้งหมดก่อน');
        }
        Department::destroy($id);

        return redirect()->route('department.index')
            ->with('success', 'ลบแผนกสำเร็จ.');
    }
}
