<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Models\Organisation\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public function create(Request $request)
    {
        $request->validate([
            'state_id' =>'required|int',
            'names' =>'required|string',
            'reg_number' =>'required|string',
        ]);
        $request['user_pid'] = getUserPid();
        $request['pid'] = public_id();
        try {
            $this->insertOrUpdateOrg($request->all());
            return redirect()->back()->with('success','Organisation created Successfully');
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            return redirect()->back()->with('error', 'Error logged');
        }
    }
    private function insertOrUpdateOrg($data){
        return Organisation::updateOrCreate([
            'pid'=>$data['pid'],
            'user_pid'=>$data['user_pid']
        ],$data);
    }
    public function index()
    {
        $data = Organisation::where('user_pid', getUserPid())->get();
        return view('organisation.index',compact('data'));
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
        $request->validate([
            'state_id' => 'required|int',
            'names' => 'required|string',
            'reg_number' => 'required|string',
        ]);
        $request['user_pid'] = getUserPid();
        $request['reg_number'] = 'bn4040';
        $request['names'] = 'HDTL';
        $request['pid'] = base64Decode($id);
        try {
            $org = Organisation::where(['pid'=> $request['pid'],'user_pid'=>$request['user_pid']])->first();
            if(!$org){
                return redirect()->back()->with('warning', 'Wrong Id or right denied');
            }
            $this->insertOrUpdateOrg($request->all());
            return redirect()->back()->with('success', 'Organisation updated Successfully');
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            logError($error);
            return redirect()->back()->with('error', 'Error logged');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pid = base64Decode($id);
    }
}
