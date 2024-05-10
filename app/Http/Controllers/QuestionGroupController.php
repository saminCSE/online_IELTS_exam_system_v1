<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionGroupController extends Controller
{

    public function QuestionGroup()
    {
        $items = DB::table("questions_group")
        ->orderBy('questions_group.id','desc')
        ->get();


        //dd($items);
        return view('admin.question_group.index',compact('items'));
    }

    public function CreateQuestionGroup()
    {

        return view('admin.question_group.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'id' => 'required|integer|unique:questions_group',
            // Replace 'your_table_name' with the actual table name
            'question' => 'required|string',
            // Add any other rules you need
        ];

        // Custom error messages
        $messages = [
            'id.required' => 'The ID field is required.',
            'id.unique' => 'This ID already taken.',
            'question.required' => 'The question field is required.',
            // Add any other custom messages
        ];

        // Validate the request
        $validatedData = $request->validate($rules, $messages);

        // Store the data in the database
        DB::table('questions_group')->insert([
            'id' => $validatedData['id'],
            'questions' => json_encode($validatedData['question']),
        ]);

        return redirect()->back()->with('message', 'Group Question added Successfully');
    }

    public function questionGroupList()
    {
        $items = DB::table('questions')
            ->whereNotNull('questions.group_id')
            ->leftJoin('question_sets','questions.question_sets_id','=','question_sets.id')
            ->leftJoin('skills','skills.id','=','question_sets.skills_id')
            ->leftJoin('types','types.id','=','question_sets.type_id')
            ->select('questions.id as q_id', 'questions.group_id as q_group_id', 'questions.title as q_title', 'questions.correct_answer as q_correct','skills.title as skillname','types.title as typename')
            ->orderBy('questions.id','desc')
            ->get();
        // dd($items);
        return view('admin.question_group.groupquestion', compact('items'));
    }

    public function questionGroupEdit($id){
        $edititem = DB::table('questions_group')->find($id);
        return view('admin.question_group.create',compact('edititem'));


    }

    public function questionGroupUpdate($id, Request $request)
{
    $rules = [
        'id' => 'required|integer|unique:questions_group,id,' . $id,
        'question' => 'required|string',
        // Add any other rules you need
    ];

    // Custom error messages
    $messages = [
        'id.required' => 'The ID field is required.',
        'id.unique' => 'This ID already taken.',
        'question.required' => 'The question field is required.',
        // Add any other custom messages
    ];

    // Validate the request
    $validatedData = $request->validate($rules, $messages);

    // Update the data in the database
    DB::table('questions_group')->where('id', $id)->update([
        'id' => $validatedData['id'],
        'questions' => json_encode($validatedData['question']),
    ]);

    return redirect()->back()->with('message', 'Group Question updated Successfully');
}


public function questionGroupDelete($id)
{
    $questionGroup = DB::table('questions_group')->find($id);

    if ($questionGroup) {
        // Record exists, proceed with deletion
        DB::table('questions_group')->where('id', $id)->delete();
        return redirect()->back()->with('message', 'Question Group Deleted Successfully');
    } else {
        // Record not found, handle accordingly (e.g., show an error message)
        return redirect()->back()->with('error', 'Question Group not found');
    }
}



}
