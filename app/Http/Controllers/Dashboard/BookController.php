<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->book == 'all') {
            return Book::all()->keyBy('id');
        } elseif ($request->user != null) {
            return Book::where('user_id', $request->user)->latest()->paginate(5);
        } elseif ($request->userReceipt != null) {
            return Book::where('user_id', $request->userReceipt)->get();
        } else {
            return Book::latest()->paginate(5);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
        $this->validate($request, [
            'number' => 'required|unique:books|integer',
            'start' => 'required|integer',
            'end' => 'required|integer'
        ]);

        return Book::create([
            'number' => $request['number'],
            'start' => $request['start'],
            'end' => $request['end'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Book $book
     * @return \Illuminate\Http\Response
     */
    public
    function show(Book $book)
    {
        dd($book);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Book $book
     * @return \Illuminate\Http\Response
     */
    public
    function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Book $book
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, Book $book)
    {
        $this->validate($request, [
            'number' => 'required|integer|unique:books,number,' . $book->id,
            'start' => 'required|integer',
            'end' => 'required|integer'
        ]);
        $book->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Book $book
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Book $book)
    {
        $book->delete();
    }
}
