<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->books != '') {
            return Receipt::where('book_id', $request->books)->latest()->paginate(5);
        } elseif ($request->lastBook != '') {
            return Receipt::select('number')->where('book_id', $request->lastBook != '')->max('number');
        } else {
            return Receipt::latest()->paginate(5);
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

//                    id: '',
//                    name: '',
//                    number: [],
//                    book_id: "",
//                    delegate_id: '',
//                    zone_id: '',
//                    crop_id: '',
//                    user_id: '',
//                    bag: [],
//                    carat: []

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'book_id' => 'required|integer',
            'zone_id' => 'required|integer',
            'delegate_id' => 'required|integer',
            'crop_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $count = count($request->number);

        $number = $request->number;
        $bag = $request->bag;
        $carat = $request->carat;

        for ($i = 0; $i < $count; $i++) {

            if ($number[$i] != 0 || $number[$i] != '') {
                $requestNumber = $number[$i];
            }

            if ($bag[$i] == 0 || $bag[$i] == '') {
                $requestBag = null;
            } else {
                $requestBag = $bag[$i];
            }
            if ($carat[$i] == 0 || $carat[$i] == '') {
                $requestCarat = null;
            } else {
                $requestCarat = $carat[$i];
            }
            Receipt::create([
                'name' => $request['name'],
                'book_id' => $request['book_id'],
                'number' => $requestNumber,
                'zone_id' => $request['zone_id'],
                'delegate_id' => $request['delegate_id'],
                'crop_id' => $request['crop_id'],
                'user_id' => $request['user_id'],
                'bag' => $requestBag,
                'carat' => $requestCarat,
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Receipt $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Receipt $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Receipt $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receipt $receipt)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'book_id' => 'required|integer',
            'zone_id' => 'required|integer',
            'bag' => 'required|integer',
            'carat' => 'required|integer',
            'delegate_id' => 'required|integer',
            'crop_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $receipt->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Receipt $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        //
    }
}
