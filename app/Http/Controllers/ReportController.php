<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Department;
use App\Models\RequestCar;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = 94;
        session()->forget(['startTime', 'endTime']);
        session(["recordrequest" => RequestCar::where('status_id', 4)
            ->orderBy('created_at', 'asc')
            ->orderBy('startTime', 'asc')
            ->orderBy('department_car', 'asc')
            ->get()]);

        $recordrequest = RequestCar::where('status_id', 4)
            ->orderBy('created_at', 'asc')
            ->orderBy('startTime', 'asc')
            ->orderBy('department_car', 'asc')
            ->paginate(10);

        $departmentcheck = Auth::user()->department_id;
        $user = User::where('department_id', Auth::user()->department_id)
            ->get()
            ->pluck('id');

        if (Auth::user()->permission_id == 2) {
            session(["recordrequest" => RequestCar::whereIn('user_id', $user)
                ->where('status_id', 4)
                ->orderBy('created_at', 'asc')
                ->orderBy('startTime', 'asc')
                ->orderBy('department_car', 'asc')
                ->get()]);

            $recordrequest = RequestCar::whereIn('user_id', $user)
                ->where('status_id', 4)
                ->orderBy('created_at', 'asc')
                ->orderBy('startTime', 'asc')
                ->orderBy('department_car', 'asc')
                ->paginate(10);

            return view('user.report', compact('recordrequest', 'a', 'departmentcheck'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        } else {

            return view('user.report', compact('recordrequest', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
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

    public function search(Request $request)
    {
        $request->session()->forget(['startTime', 'endTime','select']);
        session(["select" => $request->select]);
        $a = 94;
        $usercheck = User::where('department_id', Auth::user()->department_id)
            ->get()
            ->pluck('id');

        $user = User::where('firstname', 'LIKE', '%' . $request->name . '%')
            ->orwhere('lastname', 'LIKE', '%' . $request->name . '%')
            ->get()
            ->pluck('id');

        $regisNumber = Car::where('regisNumber', 'LIKE', '%' . $request->name . '%')
            ->get()
            ->pluck('id');

        $department = Department::where('name', 'LIKE', '%' . $request->name . '%')
            ->get()
            ->pluck('id');
        // if(($request->dateend) < ($request->datestart)){
        //     return redirect()->route('report.index')
        //         ->with('errordate', 'กรุณาตรวจสอบวันให้ถูกต้อง')->withInput();
        // }
        $departmentcheck = Auth::user()->department_id;

        //-----------หัวหน้าแผนก------------
        if (Auth::user()->permission_id == 2) {

            $daystosum = '1';
            $datesum = date('Y-m-d', strtotime($request->dateend . ' + ' . $daystosum . ' days'));

            if (isset($request->name) || ($request->dateend) || ($request->datestart)) {

                if ($request->name == null) { //ไม่มีข้อในText มีแต่ในวันที่
                    if ($request->select == 5) {

                        session(["recordrequest" => RequestCar::whereBetween('startTime', [$request->datestart, $datesum])
                            ->where('status_id', 4)
                            ->whereBetween('startTime', [$request->datestart, $datesum])
                            ->where('status_return', 1)
                            ->whereIn('user_id', $usercheck)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->get()]);

                        session(["startTime" => $request->datestart]);
                        session(["endTime" => $request->dateend]);

                        $recordrequest = RequestCar::whereBetween('startTime', [$request->datestart, $datesum])
                            ->where('status_id', 4)
                            ->whereBetween('startTime', [$request->datestart, $datesum])
                            ->where('status_return', 1)
                            ->whereIn('user_id', $usercheck)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->paginate(10);

                        return view('user.report', compact('recordrequest', 'a'))
                            ->with('i', (request()->input('page', 1) - 1) * 10);
                    } else {
                        session(["recordrequest" => RequestCar::where('status_id', 4)
                            ->whereIn('user_id', $usercheck)
                            ->whereBetween('startTime', [$request->datestart, $datesum])
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->get()]);

                        session(["startTime" => $request->datestart]);
                        session(["endTime" => $request->dateend]);

                        $recordrequest = RequestCar::where('status_id', 4)
                            ->whereIn('user_id', $usercheck)
                            ->whereBetween('startTime', [$request->datestart, $datesum])
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->paginate(10);

                        return view('user.report', compact('recordrequest', 'a'))
                            ->with('i', (request()->input('page', 1) - 1) * 10);
                    }
                } else if ($request->dateend == null && $request->datestart == null) { //มีข้อมูลในtextแต่ไม่มีข้อมูลในวันที่

                    if ($request->select == 2) {
                        session(["recordrequest" => RequestCar::where('status_id', 4)
                            ->whereIn('user_id', $usercheck)
                            ->where('department_car', 'LIKE', '%' . $request->name . '%')
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->get()]);

                        $recordrequest = RequestCar::where('status_id', 4)
                            ->whereIn('user_id', $usercheck)
                            ->where('department_car', 'LIKE', '%' . $request->name . '%')
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->paginate(10);
                    }
                    if ($request->select == 3) {
                        session(["recordrequest" => RequestCar::where('status_id', 4)
                            ->whereIn('user_id', $usercheck)
                            ->WhereIn('user_id', $user)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->get()]);

                        $recordrequest = RequestCar::where('status_id', 4)
                            ->whereIn('user_id', $usercheck)
                            ->WhereIn('user_id', $user)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->paginate(10);
                    }

                    if ($request->select == 4) {
                        session(["recordrequest" => RequestCar::where('status_id', 4)
                            ->whereIn('user_id', $usercheck)
                            ->WhereIn('car_id', $regisNumber)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->get()]);

                        $recordrequest = RequestCar::where('status_id', 4)
                            ->whereIn('user_id', $usercheck)
                            ->WhereIn('car_id', $regisNumber)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->paginate(10);
                    }

                    return view('user.report', compact('recordrequest', 'a'))
                        ->with('i', (request()->input('page', 1) - 1) * 10);
                } else {

                    if ($request->select == 2) {
                        session(["recordrequest" => RequestCar::where('status_id', 4)
                            ->whereBetween('startTime', [$request->datestart, $datesum])
                            ->whereIn('requestNo', 'LIKE', '%' . $request->name . '%')
                            ->whereIn('user_id', $usercheck)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->get()]);

                        session(["startTime" => $request->datestart]);
                        session(["endTime" => $request->dateend]);

                        $recordrequest = RequestCar::where('status_id', 4)
                            ->where('requestNo', 'LIKE', '%' . $request->name . '%')
                            ->whereBetween('startTime', [$request->datestart, $datesum])
                            ->whereIn('user_id', $usercheck)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->paginate(10);
                    }

                    if ($request->select == 3) {
                        session(["recordrequest" => RequestCar::where('status_id', 4)
                            ->where('user_id', $user)
                            ->whereBetween('startTime', [$request->datestart, $datesum])
                            ->whereIn('user_id', $usercheck)
                            ->get()]);

                        session(["startTime" => $request->datestart]);
                        session(["endTime" => $request->dateend]);

                        $recordrequest = RequestCar::where('status_id', 4)
                            ->whereBetween('startTime', [$request->datestart, $datesum])
                            ->whereIn('user_id', $user)
                            ->whereIn('user_id', $usercheck)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->paginate(10);
                    }

                    if ($request->select == 4) {
                        session(["recordrequest" => RequestCar::where('status_id', 4)
                            ->where('car_id', $regisNumber)
                            ->whereBetween('startTime', [$request->datestart, $datesum])
                            ->whereIn('user_id', $usercheck)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->get()]);

                        session(["startTime" => $request->datestart]);
                        session(["endTime" => $request->dateend]);

                        $recordrequest = RequestCar::where('status_id', 4)
                            ->whereBetween('startTime', [$request->datestart, $datesum])
                            ->whereIn('car_id', $regisNumber)
                            ->whereIn('user_id', $usercheck)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('startTime', 'asc')
                            ->orderBy('department_car', 'asc')
                            ->paginate(10);
                    }

                    return view('user.report', compact('recordrequest', 'a'))
                        ->with('i', (request()->input('page', 1) - 1) * 10);
                }
            } else {
                if ($request->select == 5) {

                    session(["recordrequest" => RequestCar::whereIn('user_id', $usercheck)
                        ->where('status_id', 4)
                        ->where('status_return', 1)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->get()]);

                    $recordrequest = RequestCar::whereIn('user_id', $usercheck)
                        ->where('status_id', 4)
                        ->where('status_return', 1)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->paginate(10);
                } else {
                    session(["recordrequest" => RequestCar::whereIn('user_id', $usercheck)
                        ->where('status_id', 4)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->get()]);

                    $recordrequest = RequestCar::whereIn('user_id', $usercheck)
                        ->where('status_id', 4)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->paginate(10);
                }
                return view('user.report', compact('recordrequest', 'a'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            }
        }
        //-----------ผู้ดูแลระบบ------------
        if (isset($request->name) || ($request->dateend) || ($request->datestart)) {

            $daystosum = '1';
            $datesum = date('Y-m-d', strtotime($request->dateend . ' + ' . $daystosum . ' days'));

            if ($request->name == null) {

                if ($request->select == 5) {

                    session(["recordrequest" => RequestCar::whereBetween('startTime', [$request->datestart, $datesum])
                        ->where('status_id', 4)
                        ->whereBetween('startTime', [$request->datestart, $datesum])
                        ->where('status_return', 1)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->get()]);

                    session(["startTime" => $request->datestart]);
                    session(["endTime" => $request->dateend]);
                    session(["name" => $request->name]);

                    $recordrequest = RequestCar::whereBetween('startTime', [$request->datestart, $datesum])
                        ->where('status_id', 4)
                        ->whereBetween('startTime', [$request->datestart, $datesum])
                        ->where('status_return', 1)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->paginate(10);

                    return view('user.report', compact('recordrequest', 'a'))
                        ->with('i', (request()->input('page', 1) - 1) * 10);
                } else {
                    session(["recordrequest" => RequestCar::whereBetween('startTime', [$request->datestart, $datesum])
                        ->where('status_id', 4)
                        ->whereBetween('startTime', [$request->datestart, $datesum])
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->get()]);

                    session(["startTime" => $request->datestart]);
                    session(["endTime" => $request->dateend]);
                    session(["name" => $request->name]);

                    $recordrequest = RequestCar::whereBetween('startTime', [$request->datestart, $datesum])
                        ->where('status_id', 4)
                        ->whereBetween('startTime', [$request->datestart, $datesum])
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->paginate(10);

                    return view('user.report', compact('recordrequest', 'a'))
                        ->with('i', (request()->input('page', 1) - 1) * 10);
                }
            } else if ($request->dateend == null && $request->datestart == null) {

                if ($request->select == 2) {
                    session(["recordrequest" => RequestCar::where('status_id', 4)

                        ->where('department_car', $department)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->get()]);

                    $recordrequest = RequestCar::where('status_id', 4)
                        ->where('department_car', $department)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->paginate(10);
                }

                if ($request->select == 3) {

                    session(["recordrequest" => RequestCar::where('status_id', 4)
                        ->WhereIn('user_id', $user)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->get()]);

                    $recordrequest = RequestCar::where('status_id', 4)
                        ->WhereIn('user_id', $user)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->paginate(10);
                }

                if ($request->select == 4) {

                    session(["recordrequest" => RequestCar::where('status_id', 4)
                        ->whereIn('car_id', $regisNumber)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->get()]);

                    $recordrequest = RequestCar::where('status_id', 4)
                        ->whereIn('car_id', $regisNumber)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->paginate(10);
                }

                return view('user.report', compact('recordrequest', 'a'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            } else {
                if ($request->select == 2) {

                    session(["recordrequest" => RequestCar::where('status_id', 4)
                        ->whereBetween('startTime', [$request->datestart, $datesum])
                        ->whereIn('department_car', $department)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->get()]);

                    session(["startTime" => $request->datestart]);
                    session(["endTime" => $request->dateend]);
                    session(["name" => $request->name]);

                    $recordrequest = RequestCar::where('status_id', 4)
                        ->where('department_car', $department)
                        ->whereBetween('startTime', [$request->datestart, $datesum])
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->paginate(10);
                    return view('user.report', compact('recordrequest', 'a'))
                        ->with('i', (request()->input('page', 1) - 1) * 10);
                }


                if ($request->select == 3) {
                    session(["recordrequest" => RequestCar::where('status_id', 4)
                        ->where('user_id', $user)
                        ->whereBetween('startTime', [$request->datestart, $datesum])
                        ->get()]);

                    session(["startTime" => $request->datestart]);
                    session(["endTime" => $request->dateend]);
                    session(["name" => $request->name]);

                    $recordrequest = RequestCar::where('status_id', 4)
                        ->whereBetween('startTime', [$request->datestart, $datesum])
                        ->whereIn('user_id', $user)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->paginate(10);
                }

                if ($request->select == 4) {
                    session(["recordrequest" => RequestCar::where('status_id', 4)
                        ->whereBetween('startTime', [$request->datestart, $datesum])
                        ->whereIn('car_id', $regisNumber)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->get()]);

                    session(["startTime" => $request->datestart]);
                    session(["endTime" => $request->dateend]);
                    session(["name" => $request->name]);

                    $recordrequest = RequestCar::where('status_id', 4)
                        ->whereBetween('startTime', [$request->datestart, $datesum])
                        ->whereIn('car_id', $regisNumber)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('startTime', 'asc')
                        ->orderBy('department_car', 'asc')
                        ->paginate(10);
                }

                return view('user.report', compact('recordrequest', 'a'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            }
        } else {

            if ($request->select == 5) {

                session(["recordrequest" => RequestCar::where('status_id', 4)
                    ->where('status_return', 1)
                    ->orderBy('created_at', 'asc')
                    ->orderBy('startTime', 'asc')
                    ->orderBy('department_car', 'asc')
                    ->get()]);

                $recordrequest = RequestCar::where('status_id', 4)
                    ->where('status_return', 1)
                    ->orderBy('created_at', 'asc')
                    ->orderBy('startTime', 'asc')
                    ->orderBy('department_car', 'asc')
                    ->paginate(10);
            } else {
                session(["recordrequest" => RequestCar::where('status_id', 4)
                    ->orderBy('created_at', 'asc')
                    ->orderBy('startTime', 'asc')
                    ->orderBy('department_car', 'asc')
                    ->get()]);

                $recordrequest = RequestCar::where('status_id', 4)
                    ->orderBy('created_at', 'asc')
                    ->orderBy('startTime', 'asc')
                    ->orderBy('department_car', 'asc')
                    ->paginate(10);
            }

            return view('user.report', compact('recordrequest', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }
    }

    public function exportpdf(Request $request)
    {

        $datenow = date('Y-m-d\TH:i');
        $recordrequest = (session("recordrequest"));
        $startTime = (session("startTime"));
        $endTime = (session("endTime"));
        $select = (session("select"));
        $name = (session("name"));
        $i = 0;
        // return $recordrequest->withQueryString()->currentPage();
        $pdf = \App::make('dompdf.wrapper');
        $pdf = PDF::loadView('user.pdfrecord', compact('recordrequest', 'i', 'datenow', 'startTime', 'endTime','select','name'))->setPaper('a4', 'landscape');
        $pdf->getDOMPdf()->set_option('isPhpEnabled', true);
        return $pdf->stream();
        //  return $pdf->download('vmsrequest.pdf');
    }

    public function exportpdfdetails(Request $request, $id)
    {
        $datenow = date('Y-m-d\TH:i');
        $recordrequest = RequestCar::where('id', $id)->get();
        $pdf = PDF::loadView('user.pdfdetails', compact('recordrequest', 'datenow'));
        return $pdf->download('vmsrequestdetails.pdf');
    }
}
