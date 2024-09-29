<?php

namespace App\Http\Controllers;

use App\Models\Purok;
use Illuminate\Http\Request;

class PurokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getPuroks($barangayId)
    {
        $puroks = Purok::where('barangay_id', $barangayId)->get();

        return response()->json(['puroks' => $puroks]);
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
    public function show(Purok $purok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purok $purok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purok $purok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purok $purok)
    {
        //
    }
}
