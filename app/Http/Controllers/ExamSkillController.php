<?php

namespace App\Http\Controllers;

use App\Models\ExamTypeModel;
use App\Models\SkillModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ExamSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $skills=DB::table('skills')
       ->leftJoin('types','types.id','=','skills.type_id')
       ->select('skills.*','types.title as type_title')
       ->get();
       return view('admin.skills.index',compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = ['' => 'Select Exam Types....'] + ExamTypeModel::select('id', 'title')->where('is_active', 1)->get()->pluck('title', 'id')->toArray();
        return view('admin.skills.create',compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            //dd($data);
            $user = SkillModel::create($data);
            if (!$user) {
                Session::flash('error', 'An error occurred');
                return redirect()->route('skills.create');
            }

            Session::flash('status', 'New Skills Created Successfully');
            return redirect()->route('skills.index');
        } catch (Exception $e) {
            // Handle other exceptions
            Session::flash('error', 'An error occurred: ' . $e->getMessage());
            return redirect()->route('skills.create'); // Redirect back to the batch index page with an error message
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
    public function edit(SkillModel $skill)
    {
        $type = ['' => 'Select Exam Types....'] + ExamTypeModel::select('id', 'title')->where('is_active', 1)->get()->pluck('title', 'id')->toArray();
        return view('admin.skills.create')->with(['item' => $skill ,'type'=>$type]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SkillModel $skill)
    {
        try {
            $skill->update($request->all());
            return redirect()->route('skills.index')->with('status', 'Skills Update Successfully');
        } catch (Exception $e) {
            // Handle exceptions if any occur during the update
            Session::flash('error', 'An error occurred: ' . $e->getMessage());
            return redirect()->route('skills.index'); // Redirect back to the batch index page with an error message
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SkillModel $skill)
    {
        $skill->delete();
        return redirect()
            ->back()
            ->with('delete_status', 'Skills Delete Successfully');
    }
}
