<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{


    public function index()
    {
        return view('pages.user.report');
    }

    public function download()
    {
        $data = ['title' => 'Test title'];
        $pdf = PDF::loadView('panels.report-panel', $data);
        return $pdf->download('report.pdf');
    }


}
