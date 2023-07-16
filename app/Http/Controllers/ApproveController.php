<?php

namespace App\Http\Controllers;

use App\Models\RequestCar;
use App\Models\User;
use App\Notifications\SendEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ApproveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = 92;
        $departmentcheck = Auth::user()->department_id;
        //แอดมิน
        if (Auth::user()->permission_id == 1) {
            $record = RequestCar::where('status_id', 1)
                ->orderBy('department_car', 'asc')
                ->orderBy('created_at', 'asc')
                ->paginate(10);

            if (count($record) == 0) {
                return view('user.approve', compact('record', 'a'));
            }

            return view('user.approve', compact('record', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }

        $record = RequestCar::where('department_car', $departmentcheck)
            ->where('status_id', 1)
            ->paginate(10);

        if (count($record) == 0) {
            return view('user.approve', compact('record', 'a'));
        }

        return view('user.approve', compact('record', 'a'))
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
    public function update(Request $request, $id)
    {
        // $request = $request->except(['_token', '_method']);

        $record_approve = RequestCar::find($id);

        $record_approve->status_id = 2;
        $record_approve->save();

        return redirect()->route('approve.index')
            ->with('success', 'อนุมัติสำเร็จ');
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
            'greeting' => 'คำขอของคุณไม่ได้รับการอนุมัติ',
            'body' => 'เข้าสู่ระบบเพื่อขอใช้รถใหม่อีกครั้ง',
            'actiontext' => 'กดคลิกเพื่อเข้าสู่ระบบ',
            'actionurl' => 'http://127.0.0.1:8000/login',
            'lastline' => $request->detail,
        ];

        Notification::send($user, new SendEmailNotification($details));

        RequestCar::destroy($id);
        return redirect()->route('approve.index')
            ->with('success', 'ไม่อนุมัติคำขอนี้');
    }

}
