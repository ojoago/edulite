<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Models\Organisation\OrgUserAccess;
use Illuminate\Http\Request;

class OrgUserAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $request->validate([
            'org_user_pid'=>'required',
            'access'=>'required'
        ]);
        
        try {
            OrgUserAccess::updateOrCreate([
                'org_user_pid' => $request['org_user_pid']
            ], $request->all());
            return redirect()->back()->with('success', 'Access right updated');
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            dd($error);
            return redirect()->back()->with('error', 'Error logged');
        }
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
