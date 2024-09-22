<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Awardee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Count
        $totalAwardees = Awardee::count();
        $totalApplicants = Applicant::count();

        // Pass the total count to the view
        return view('dashboard', compact('totalAwardees', 'totalApplicants'));
    }

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
