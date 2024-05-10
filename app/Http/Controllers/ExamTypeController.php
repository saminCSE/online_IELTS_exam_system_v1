<?php

namespace App\Http\Controllers;

use App\Models\ExamTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;

class ExamTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types=ExamTypeModel::get();
        return view('admin.types.index',compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.defaultpage')->with('message','Sorry, this facility has been sealed');
        // $is_active = CommonController::ActiveStatus();
        // return view('admin.types.create',compact('is_active'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validate that the 'name' field is not empty
    if (empty($request->input('title'))) {
        Session::flash('error', 'Title field is required');
        return redirect()->route('types.create');
    }

    // You can add more validation checks for other fields if needed.

    try {
        $data = $request->all();
        $user = ExamTypeModel::create($data);

        if (!$user) {
            Session::flash('error', 'An error occurred');
            return redirect()->route('types.create');
        }

        Session::flash('status', 'New Types Created Successfully');
        return redirect()->route('types.index');
    } catch (Exception $e) {
        // Handle other exceptions
        Session::flash('error', 'An error occurred: ' . $e->getMessage());
        return redirect()->route('types.create');
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
    public function edit(ExamTypeModel $type)
    {
        $is_active = CommonController::ActiveStatus();
        return view('admin.types.create')->with(['item' => $type, 'is_active' =>$is_active]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,ExamTypeModel $type)
    {
        try {
            $type->update($request->all());
            return redirect()->route('types.index')->with('status', 'Types Update Successfully');
        } catch (Exception $e) {
            // Handle exceptions if any occur during the update
            Session::flash('error', 'An error occurred: ' . $e->getMessage());
            return redirect()->route('types.index'); // Redirect back to the batch index page with an error message
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamTypeModel $type)
    {
        $type->delete();
        return redirect()
            ->back()
            ->with('delete_status', 'Type Delete Successfully');
    }
}
