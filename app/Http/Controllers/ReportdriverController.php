<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Prefix;
use Illuminate\Http\Request;
use PDF;

class ReportdriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = 94;
        session(["driver" => $driver = Driver::paginate(10)]);

        return view('user.reportdriver', compact('driver', 'a'))
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
        // admin
        if (isset($request->name)) {
            $search_text = $request->name;

            $prefix = Prefix::where('name', 'LIKE', '%' . $search_text . '%')
                ->get()
                ->pluck('id');

            session(["driver" => Driver::where('drivernumber', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->orwhere('firstname', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->orwhere('lastname', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->orwhere('firstname', 'LIKE', '%' . $search_text . '%')
                    ->where('active', 1)
                    ->orwhereIn('prefix_id', $prefix)
                    ->where('active', 1)
                    ->get()]);

            $driver = Driver::where('drivernumber', 'LIKE', '%' . $search_text . '%')
                ->where('active', 1)
                ->orwhere('firstname', 'LIKE', '%' . $search_text . '%')
                ->where('active', 1)
                ->orwhere('lastname', 'LIKE', '%' . $search_text . '%')
                ->where('active', 1)
                ->orwhere('firstname', 'LIKE', '%' . $search_text . '%')
                ->where('active', 1)
                ->orwhereIn('prefix_id', $prefix)
                ->where('active', 1)
                ->paginate(10);

            return view('user.reportdriver', compact('driver', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);

        } else {
            session(["driver" => Driver::get()]);

            $driver = Driver::paginate(10);

            return view('user.reportdriver', compact('driver', 'a'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }
    }
    public function exportpdfdriver(Request $request)
    {
        $datenow = date('Y-m-d\TH:i');
        $driver = (session("driver"));
        $i = 0;
        $pdf = \App::make('dompdf.wrapper');
        $pdf = PDF::loadView('user.pdfdriver', compact('driver', 'i', 'datenow'));
        $pdf->getDOMPdf()->set_option('isPhpEnabled', true);
        return $pdf->download('vmsdriver.pdf');
    }
}
