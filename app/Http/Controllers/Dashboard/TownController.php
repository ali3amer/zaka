<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Town;
use Illuminate\Http\Request;

class TownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->town == 'all') {
            return Town::all();
        } elseif ($request->state != null) {
            return Town::with('state')->where('state_id', $request->state)->latest()->paginate(5);
        } else {
            return Town::with('state')->latest()->paginate(5);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:towns|string|max:191',
            'state_id' => 'required|integer'
        ]);
        return Town::create([
            'name' => $request['name'],
            'state_id' => $request['state_id'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Town $town
     * @return \Illuminate\Http\Response
     */
    public function show(Town $town)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Town $town
     * @return \Illuminate\Http\Response
     */
    public function edit(Town $town)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Town $town
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Town $town)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191|unique:towns,name,' . $town->id,
            'state_id' => 'required|integer'
        ]);
        $town->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Town $town
     * @return \Illuminate\Http\Response
     */
    public function destroy(Town $town)
    {
        $town->delete();
    }
}
