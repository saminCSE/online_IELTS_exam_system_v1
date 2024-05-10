<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnswerSubmitController extends Controller
{
    public function SubmitWrittingAnswer(Request $request)
    {

        $questionSetId = $request->input('questionSetId');
        $answers = $request->input('answers');

        $studentId = Auth::guard('student')->user()->id;

        // Prepare data to store in the database
        DB::table('exam_ans_submit')->insert([
            'student_id' => $studentId,
            'question_sets_id' => $questionSetId,
            'submit_answer' => json_encode($answers),
        ]);

        return response()->json(['message' => 'Data submitted successfully']);
    }

    public function WrittingAnswer(Request $request)
    {

        $item = DB::table('question_sets')
            ->leftJoin('skills', 'skills.id', '=', 'question_sets.skills_id')
            ->leftJoin('test_title', 'test_title.id', '=', 'question_sets.title_id')
            ->leftJoin('exam_ans_submit', 'exam_ans_submit.question_sets_id', '=', 'question_sets.id')
            ->leftJoin('students', 'students.id', '=', 'exam_ans_submit.student_id')
            ->select('skills.title as skill_title', 'test_title.title as test_title', 'students.name as student_name', 'exam_ans_submit.*')
            ->whereNotNull('exam_ans_submit.id')
            ->orderByDesc('exam_ans_submit.id') // Filter for records that have associated exam_ans_submit entries
            ->get();
        //dd($item);
        return view('admin.writting_ans_approved.index', compact('item'));
    }

    public function update(Request $request)
    {
        // Insert the score into the Score model/table
        DB::table('exam_user')->insert([
            'question_sets_id' => $request->question_set_id,
            'student_id' => $request->student_id,
            'score' => $request->score,
        ]);
        return response()->json(['success' => true]);
    }
}
