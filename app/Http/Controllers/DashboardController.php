<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Awardee;
use App\Models\TaggedAndValidatedApplicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
//    public function getChartData(Request $request)
//    {
//        $year = $request->input('year');
//
//        if ($year === 'Overall Total') {
//            $applicants = Applicant::select(DB::raw('COUNT(*) as count'), DB::raw('MONTH(date_applied) as month'))
//                ->groupBy(DB::raw('MONTH(date_applied)'))
//                ->pluck('count');
//
//            $taggedValidated = Applicant::select(DB::raw('COUNT(*) as count'), DB::raw('MONTH(date_applied) as month'))
//                ->where('is_tagged', true)
//                ->groupBy(DB::raw('MONTH(date_applied)'))
//                ->pluck('count');
//
//            $informalSettlers = TaggedAndValidatedApplicant::select(DB::raw('COUNT(*) as count'), DB::raw('MONTH(tagging_date) as month'))
//                ->groupBy(DB::raw('MONTH(tagging_date)'))
//                ->pluck('count');
//        } else {
//            $applicants = Applicant::select(DB::raw('COUNT(*) as count'), DB::raw('MONTH(date_applied) as month'))
//                ->whereYear('date_applied', $year)
//                ->groupBy(DB::raw('MONTH(date_applied)'))
//                ->pluck('count');
//
//            $taggedValidated = Applicant::select(DB::raw('COUNT(*) as count'), DB::raw('MONTH(date_applied) as month'))
//                ->whereYear('date_applied', $year)
//                ->where('is_tagged', true)
//                ->groupBy(DB::raw('MONTH(date_applied)'))
//                ->pluck('count');
//
//            $informalSettlers = TaggedAndValidatedApplicant::select(DB::raw('COUNT(*) as count'), DB::raw('MONTH(tagging_date) as month'))
//                ->whereYear('tagging_date', $year)
//                ->groupBy(DB::raw('MONTH(tagging_date)'))
//                ->pluck('count');
//        }
//
//        return response()->json([
//            'applicants' => $applicants->toArray(),
//            'taggedValidated' => $taggedValidated->toArray(),
//            'informalSettlers' => $informalSettlers->toArray()
//        ]);
//    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Awardee $awardee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Awardee $awardee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Awardee $awardee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Awardee $awardee)
    {
        //
    }
}
