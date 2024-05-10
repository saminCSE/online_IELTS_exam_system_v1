<?php

namespace App\Http\Controllers;

use App\Models\ExamTypeModel;
use App\Models\QuestionSetModel;
use App\Models\SkillModel;
use App\Models\TestTitleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions_set = DB::table('question_sets')
            ->leftJoin('types', 'types.id', '=', 'question_sets.type_id')
            ->leftJoin('skills', 'skills.id', '=', 'question_sets.skills_id')
            ->leftJoin('test_title', 'test_title.id', '=', 'question_sets.title_id')
            ->select('question_sets.*', 'types.title as type_title', 'skills.title as skill_title','test_title.title as test_title')
            ->get();
        foreach ($questions_set as $set) {
            $set->part_info = json_decode($set->part_info);
        }

        // dd($questions_set);
        return view('admin.questions_set.index', compact('questions_set'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_active = CommonController::ActiveStatus();
        $type = ['' => 'Select Exam Types....'] + ExamTypeModel::select('id', 'title')->where('is_active', 1)->get()->pluck('title', 'id')->toArray();
        $skill = ['' => 'Select Skills....'] + SkillModel::select('id', 'title')->get()->pluck('title', 'id')->toArray();
        $testTitle = ['' => 'Select Test Tile....'] + TestTitleModel::select('id', 'title')->get()->pluck('title', 'id')->toArray();
        return view('admin.questions_set.create', compact('is_active', 'type', 'skill','testTitle'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $questionSet = new QuestionSetModel();
        $questionSet->type_id = $request->type_id;
        $questionSet->skills_id = $request->skills_id;
        $questionSet->title_id = $request->title_id;
        $questionSet->exam_taken = $request->exam_taken;
        $questionSet->exam_duration = $request->exam_duration;
        $questionSet->total_question = $request->total_question;
        $questionSet->total_part = $request->total_part;
        $partInfo = [];
        for ($i = 0; $i < $request->total_part; $i++) {
            $partInfo[$i]['id'] = $request->input("part_info.$i.id");
            $partInfo[$i]['title'] = $request->input("part_info.$i.title");
            $partInfo[$i]['start'] = $request->input("part_info.$i.start");
            $partInfo[$i]['end'] = $request->input("part_info.$i.end");
            $partInfo[$i]['short_title'] = $request->input("part_info.$i.short_title");
            $partInfo[$i]['question_passage'] = $request->input("part_info.$i.question_passage");
        }

        $questionSet->part_info = json_encode($partInfo);

        $audioPath = $request->file('audio_file');

        if ($audioPath) {
            $audio = $audioPath->getClientOriginalName();
            $audioPath->move(public_path('uploads/audio'), $audio);
            $questionSet->audio_file = 'uploads/audio/' . $audio;
        }

        $questionSet->is_active = $request->is_active;

        // dd($questionSet);
        $questionSet->save();
        return redirect()->route('questions_set.index')->with('status', 'Question Set created successfully');
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
    public function edit(QuestionSetModel $questions_set)
    {
        $is_active = CommonController::ActiveStatus();
        return view('admin.questions_set.edit')->with(['item' => $questions_set,'is_active' =>$is_active]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,QuestionSetModel $questions_set)
    {
    $questions_set->exam_duration = $request->exam_duration;
    $questions_set->total_question = $request->total_question;
    $questions_set->total_part = $request->total_part;

    // Update the part_info field
    $partInfo = [];
    for ($i = 0; $i < $request->total_part; $i++) {
        $partInfo[$i]['id'] = $request->input("part_info.$i.id");
        $partInfo[$i]['title'] = $request->input("part_info.$i.title");
        $partInfo[$i]['start'] = $request->input("part_info.$i.start");
        $partInfo[$i]['end'] = $request->input("part_info.$i.end");
        $partInfo[$i]['short_title'] = $request->input("part_info.$i.short_title");
        $partInfo[$i]['question_passage'] = $request->input("part_info.$i.question_passage");
    }
    $questions_set->part_info = json_encode($partInfo);

    // Handle the audio file if it's being updated
    $audioPath = $request->file('audio_file');
    if ($audioPath) {
        // Handle audio file upload and update the audio_file field
    }

    $questions_set->is_active = $request->is_active;

    $questions_set->save();

    return redirect()->back()->with('success', 'Question Set updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionSetModel $questions_set)
    {
        $questions_set->delete();
        return redirect()
            ->back()
            ->with('delete_status', 'Question Set Delete Successfully');
    }

    public function fetchSkills(Request $request)
    {
        $type_id = $request->input('type_id');

        $skills = SkillModel::select('id', 'title')->where('type_id', $type_id)->get();

        $skillOptions = $skills->pluck('title', 'id')->toArray();

        //dd($skillOptions);

        return response()->json($skillOptions);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName); // Store the image in the 'uploads' directory within the public folder.

            return response()->json([
                'url' => asset('uploads/' . $imageName), // Generate the URL relative to the 'uploads' directory.
            ]);
        }
        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    public function SetStatusUpdate(Request $request)
    {

        $status = QuestionSetModel::find($request->id);
        $status->is_active = $request->is_active;
        $status->update();
        return response()->json(['success' => 'Status change successfully.']);
    }

    public function setActive(Request $request){
        $items = QuestionSetModel::where('type_id', $request->type_id)->where('title_id', $request->title_id)->get();

        $itemstoinactiveall = QuestionSetModel::where('type_id', $request->type_id)->get();

        foreach($itemstoinactiveall as $itemtoinactiveall){
            $itemtoinactiveall->is_active = 0;
            $itemtoinactiveall->save();
        }
        foreach($items as $item){
            $item->is_active = 1;
            $item->save();
        }
        return redirect()->back()->with('success','Set activated successfully.');
    }
    public function setInactive(Request $request){
        $items = QuestionSetModel::where('type_id', $request->type_id)->where('title_id', $request->title_id)->get();
        foreach($items as $item){
            $item->is_active = 0;
            $item->save();
        }
        return redirect()->back()->with('success','Set inactivated successfully.');
    }
}



