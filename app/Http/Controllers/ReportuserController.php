<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class ReportuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = 94;
        session(["user" => $user = User::whereNotIn('permission_id', [1])
                ->where('active', 1)
                ->orderBy('department_id', 'asc')
                ->orderBy('permission_id', 'asc')
                ->orderBy('employeenumber', 'asc')
                ->paginate(10)]);

        $departmentcheck = Auth::user()->department_id;

        if (Auth::user()->permission_id == 2) {
            session(["user" => $user = User::where('department_id', $departmentcheck)
                    ->where('active', 1)
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')
                    ->paginate(10)]);
        }

        return view('user.reportuser', compact('user', 'a'))
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
        $a = 94;
        $departmentcheck = Auth::user()->department_id;
        // role หัวหน้าแผนก
        if (Auth::user()->permission_id == 2) {
            $search_text = $request->name;

            $department = Department::where('name', 'LIKE', '%' . $search_text . '%')
                ->get()
                ->pluck('id');

            $permission = Permission::where('name', 'LIKE', '%' . $search_text . '%')
                ->get()
                ->pluck('id');

            if ($request->select == 3) {
                session(["user" => User::where('department_id', $departmentcheck)
                        ->where('firstname', 'LIKE', '%' . $search_text . '%')
                        ->where('active', 1)
                        ->orderBy('department_id', 'asc')
                        ->orderBy('permission_id', 'asc')
                        ->orderBy('employeenumber', 'asc')

                        ->orwhere('department_id', $departmentcheck)
                        ->where('lastname', 'LIKE', '%' . $search_text . '%')
                        ->where('active', 1)
                        ->orderBy('department_id', 'asc')
                        ->orderBy('permission_id', 'asc')
                        ->orderBy('employeenumber', 'asc')
                        ->get()]);

                $user = User::where('department_id', $departmentcheck)
                    ->where('firstname', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')

                    ->orwhere('department_id', $departmentcheck)
                    ->where('lastname', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')
                    ->paginate(10);

                return view('user.reportuser', compact('user', 'a'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            } elseif ($request->select == 2) {
                session(["user" => User::where('department_id', $departmentcheck)
                        ->where('employeenumber', 'LIKE', '%' . $search_text . '%')
                        ->where('active', 1)
                        ->orderBy('department_id', 'asc')
                        ->orderBy('permission_id', 'asc')
                        ->orderBy('employeenumber', 'asc')
                        ->get()]);

                $user = User::where('department_id', $departmentcheck)
                    ->where('employeenumber', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')
                    ->paginate(10);

                return view('user.reportuser', compact('user', 'a'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            } elseif ($request->select == 4) {
                session(["user" => User::where('department_id', $departmentcheck)
                        ->where('tel', 'LIKE', '%' . $search_text . '%')
                        ->where('active', 1)
                        ->orderBy('department_id', 'asc')
                        ->orderBy('permission_id', 'asc')
                        ->orderBy('employeenumber', 'asc')
                        ->get()]);

                $user = User::where('department_id', $departmentcheck)
                    ->where('tel', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')
                    ->paginate(10);

                return view('user.reportuser', compact('user', 'a'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            } elseif ($request->select == 5) {
                session(["user" => User::where('department_id', $departmentcheck)
                        ->whereIn('department_id', $department)
                        ->where('active', 1)
                        ->orderBy('department_id', 'asc')
                        ->orderBy('permission_id', 'asc')
                        ->orderBy('employeenumber', 'asc')
                        ->get()]);

                $user = User::where('department_id', $departmentcheck)
                    ->whereIn('department_id', $department)
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')
                    ->paginate(10);

                return view('user.reportuser', compact('user', 'a'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            } else {
                session(["user" => User::where('department_id', $departmentcheck)
                        ->where('active', 1)
                        ->orderBy('department_id', 'asc')
                        ->orderBy('permission_id', 'asc')
                        ->orderBy('employeenumber', 'asc')
                        ->get()]);

                $user = User::where('department_id', $departmentcheck)
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')
                    ->paginate(10);

                return view('user.reportuser', compact('user', 'a'))
                    ->with('i', (request()->input('page', 1) - 1) * 10);
            }
        }

        // admin
        $search_text = $request->name;

        $department = Department::where('name', 'LIKE', '%' . $search_text . '%')
            ->get()
            ->pluck('id');

        $permission = Permission::where('name', 'LIKE', '%' . $search_text . '%')
            ->get()
            ->pluck('id');

        if ($request->select == 3) {
            session(["user" => User::where('firstname', 'LIKE', '%' . $search_text . '%')
                    ->whereNotIn('permission_id', [1])
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')

                    ->orwhere('lastname', 'LIKE', '%' . $search_text . '%')
                    ->whereNotIn('permission_id', [1])
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')
                    ->get()]);

            $user = User::where('firstname', 'LIKE', '%' . $search_text . '%')
                ->whereNotIn('permission_id', [1])
                ->where('active', 1)
                ->orderBy('department_id', 'asc')
                ->orderBy('permission_id', 'asc')
                ->orderBy('employeenumber', 'asc')

                ->orwhere('lastname', 'LIKE', '%' . $search_text . '%')
                ->whereNotIn('permission_id', [1])
                ->where('active', 1)
                ->orderBy('department_id', 'asc')
                ->orderBy('permission_id', 'asc')
                ->orderBy('employeenumber', 'asc')
                ->paginate(10);

            return view('user.reportuser', compact('user', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);

        } elseif ($request->select == 2) {
            session(["user" => User::where('employeenumber', 'LIKE', '%' . $search_text . '%')
                    ->whereNotIn('permission_id', [1])
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')
                    ->get()]);

            $user = User::where('employeenumber', 'LIKE', '%' . $search_text . '%')
                ->whereNotIn('permission_id', [1])
                ->where('active', 1)
                ->orderBy('department_id', 'asc')
                ->orderBy('permission_id', 'asc')
                ->orderBy('employeenumber', 'asc')
                ->paginate(10);

            return view('user.reportuser', compact('user', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);

        } elseif ($request->select == 4) {
            session(["user" => User::where('tel', 'LIKE', '%' . $search_text . '%')
                    ->whereNotIn('permission_id', [1])
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')
                    ->get()]);

            $user = User::where('tel', 'LIKE', '%' . $search_text . '%')
                ->whereNotIn('permission_id', [1])
                ->where('active', 1)
                ->orderBy('department_id', 'asc')
                ->orderBy('permission_id', 'asc')
                ->orderBy('employeenumber', 'asc')
                ->paginate(10);

            return view('user.reportuser', compact('user', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);

        } elseif ($request->select == 5) {
            session(["user" => User::whereIn('department_id', $department)
                    ->whereNotIn('permission_id', [1])
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')
                    ->get()]);

            $user = User::whereIn('department_id', $department)
                ->whereNotIn('permission_id', [1])
                ->where('active', 1)
                ->orderBy('department_id', 'asc')
                ->orderBy('permission_id', 'asc')
                ->orderBy('employeenumber', 'asc')
                ->paginate(10);

            return view('user.reportuser', compact('user', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            session(["user" => User::whereNotIn('permission_id', [1])
                    ->where('active', 1)
                    ->orderBy('department_id', 'asc')
                    ->orderBy('permission_id', 'asc')
                    ->orderBy('employeenumber', 'asc')
                    ->get()]);

            $user = User::whereNotIn('permission_id', [1])
                ->where('active', 1)
                ->orderBy('department_id', 'asc')
                ->orderBy('permission_id', 'asc')
                ->orderBy('employeenumber', 'asc')
                ->paginate(10);

            return view('user.reportuser', compact('user', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }
    }

    public function exportpdfuser(Request $request)
    {
        $datenow = date('Y-m-d\TH:i');
        $user = (session("user"));
        $i = 0;
        // $pdf = PDF::loadView('user.pdfuser', compact('user', 'i', 'datenow'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf = PDF::loadView('user.pdfuser', compact('user', 'i', 'datenow'));
        $pdf->getDOMPdf()->set_option('isPhpEnabled', true);
        return $pdf->download('vmsemployee.pdf');
        //    return $pdf->stream();

    }
}
