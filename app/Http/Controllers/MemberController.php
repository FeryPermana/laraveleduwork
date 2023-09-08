<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.member.index');
    }

    public function api()
    {
        $members = Member::all();
        $datatables = datatables()->of($members)
            ->addColumn('date', function ($member) {
                return format_tanggal($member->created_at);
            })
            ->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:members,name',
            'email' => 'required|unique:members,email',
            'phone_number' => 'required',
            'address' => 'required'
        ]);

        $data = $request->all();
        Member::create($data);

        return redirect()->route('members.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(member $member)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|unique:catalogs,name,' . $member->id,
            'email' => 'required|unique:members,email,'  . $member->id,
            'phone_number' => 'required',
            'address' => 'required'
        ]);

        $data = $request->all();
        $member->update($data);

        return redirect()->route('members.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
    }
}
