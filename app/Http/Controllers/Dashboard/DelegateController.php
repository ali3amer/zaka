<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Delegate;
use Illuminate\Http\Request;

class DelegateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->delegate == 'all') {
            return Delegate::with('zones')->get();
        } elseif ($request->zoneReceipt != null) {
            return Delegate::with('zones')->get();
        } else {
            return Delegate::with('zones:zone_id')->latest()->paginate(5);
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
        $this->validate($request, [
            'name'  =>  'required|unique:delegates|string|max:191',
            'phone'  =>  'required|string|max:191'
        ]);

        $delegate = Delegate::create([
            'name'  =>  $request['name'],
            'phone'  =>  $request['phone']
        ]);

        $delegate->zones()->sync($request->zones);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Delegate  $delegate
     * @return \Illuminate\Http\Response
     */
    public function show(Delegate $delegate)
    {
//        $zones = [];
//        foreach ($delegate->zones()->select('zone_id')->get() as $zone) {
//            $zones[$zone->zone_id] = $zone->zone_id;
//        }
//        return array_keys($zones);

        return $delegate->zones()->get();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Delegate  $delegate
     * @return \Illuminate\Http\Response
     */
    public function edit(Delegate $delegate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Delegate  $delegate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delegate $delegate)
    {
        $this->validate($request, [
            'name'  =>  'required|string|max:191|unique:delegates,name,'.$delegate->id,
            'phone'  =>  'required|string|max:191'
        ]);

        $delegate->update([
            'name'  =>  $request['name'],
            'phone'  =>  $request['phone']
        ]);

        $delegate->zones()->sync($request->zones);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Delegate  $delegate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delegate $delegate)
    {
        $delegate->zones()->detach();
        $delegate->delete();
    }
}
