<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.author.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function api()
    {
        $authors = Author::all();

        $datatables = datatables()->of($authors)
            ->addColumn('date', function ($author) {
                return format_tanggal($author->created_at);
            })
            ->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:authors,name',
            'email' => 'required|unique:authors,email',
            'phone_number' => 'required',
            'address' => 'required'
        ]);

        $data = $request->all();
        Author::create($data);

        return redirect()->route('authors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|unique:authors,name,' . $author->id,
            'email' => 'required|unique:authors,email,' . $author->id,
            'phone_number' => 'required',
            'address' => 'required'
        ]);

        $author->update($request->all());

        return redirect()->route('authors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
    }
}
