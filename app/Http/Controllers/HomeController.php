<?php

namespace App\Http\Controllers;

use App\Exports\ApplicantsDataExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function exportApplicants()
    {
        return Excel::download(new ApplicantsDataExport, 'applicants-data.xlsx');
    }
}
