<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Todo;
use Auth;

class TodoController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ErrorMsg = "";
        DB::beginTransaction();
        try
        {

            Todo::create([
                'title' => $request->title,
                'deadline' => $request->deadline,
                'created_by' => Auth::user()->id
            ]);


        } catch (\Throwable $e) {
            DB::rollback();
            $ErrorMsg = $e->getMessage();
        }
        if ($ErrorMsg == "") {
            DB::commit();
            return redirect()->back()->with('message', 'new task Added successfully.');
        } else {

            return redirect()->back()->with('message', $ErrorMsg);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $ErrorMsg = "";
        DB::beginTransaction();
        try
        {

            Todo::where('id',$id)->update([
                'completed_by' => Auth::user()->id,
                'completed_at' => date(now()),
            ]);


        } catch (\Throwable $e) {
            DB::rollback();
            $ErrorMsg = $e->getMessage();
        }
        if ($ErrorMsg == "") {
            DB::commit();
            return redirect()->back()->with('message', 'Completed successfully.');
        } else {

            return redirect()->back()->with('message', $ErrorMsg);
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
       $ErrorMsg = "";
        DB::beginTransaction();
        try
        {

            Todo::where('id',$id)->delete();


        } catch (\Throwable $e) {
            DB::rollback();
            $ErrorMsg = $e->getMessage();
        }
        if ($ErrorMsg == "") {
            DB::commit();
            return redirect()->back()->with('message', 'Task deleted successfully.');
        } else {

            return redirect()->back()->with('message', $ErrorMsg);
        }
    }
}
