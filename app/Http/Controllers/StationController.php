<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Project;
use App\Models\Station;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stations = Station::all();
        return Inertia::render('Stations/Index', compact('stations'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $station = Station::find($id);
        $projects = Project::select('Id', 'Name')->get();
        $branches = Branch::select('Id', 'Name')->get();
        return Inertia::render('Stations/Edit', [

            'station' => $station,
            'projects' => $projects,
            'branches' => $branches


        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $station = Station::find($id);
        $station->update($request->only(['name','station_id','branch_id','project_id']));


        return to_route('stations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
