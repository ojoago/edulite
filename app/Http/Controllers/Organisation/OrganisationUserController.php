<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Models\Organisation\OrganisationUser;
use Illuminate\Http\Request;

class OrganisationUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = OrganisationUser::where('org_pid', '16712560J5U0026N927523U1SN67')->get();
        return view('organisation.users',compact('data'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'org_pid'=>'required|string',
             'user_pid'=>'required|string'
            ]);
        try {
            $request['pid'] = public_id();
            OrganisationUser::create($request->all());
            return redirect()->back()->with('success', 'Error logged');
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
            return redirect()->back()->with('error', 'Error logged');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
