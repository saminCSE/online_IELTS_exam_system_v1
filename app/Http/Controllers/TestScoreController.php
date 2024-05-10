<?php

namespace App\Http\Controllers;

use App\Models\QuestionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestScoreController extends Controller
{
    public function AcademicReadingScore(Request $request)
    {
        $selectedOptions = urldecode($request->input('selectedOptions'));
        $questionId = $request->questionId;

        // 1. Retrieve all correct answers for the given question set
        $correctAnswers = $this->getAllCorrectAnswersForQuestionSet($request->questionSetId);

        // 2. Retrieve the selected correct answer for the given question
        $correctAnswer = $this->getCorrectAnswerForQuestion($questionId);

        // 3. Calculate the score by comparing selected options with the user's answer
        $score = $this->calculateScore($selectedOptions, $correctAnswers, $correctAnswer);

        // 4. Get the logged-in student's ID
        $studentId = Auth::guard('student')->user()->id;

        // 5. Store the score in the database
        DB::table('exam_user')->insert([
            'student_id' => $studentId,
            'question_sets_id' => $request->questionSetId,
            'score' => $score,
        ]);
        return redirect()->route('academic.writing.confirm_details');
        // return response()->json(['message' => 'Score stored successfully', 'score' => $score]);
    }

    public function GeneralReadingScore(Request $request)
    {
        $selectedOptions = urldecode($request->input('selectedOptions'));
        $questionId = $request->questionId;

        // 1. Retrieve all correct answers for the given question set
        $correctAnswers = $this->getAllCorrectAnswersForQuestionSet($request->questionSetId);

        // 2. Retrieve the selected correct answer for the given question
        $correctAnswer = $this->getCorrectAnswerForQuestion($questionId);

        // 3. Calculate the score by comparing selected options with the user's answer
        $score = $this->calculateScore($selectedOptions, $correctAnswers, $correctAnswer);

        // 4. Get the logged-in student's ID
        $studentId = Auth::guard('student')->user()->id;

        // 5. Store the score in the database
        DB::table('exam_user')->insert([
            'student_id' => $studentId,
            'question_sets_id' => $request->questionSetId,
            'score' => $score,
        ]);
        return redirect('test_score')->with('status', 'Submitted successfully');
        // return response()->json(['message' => 'Score stored successfully', 'score' => $score]);
    }

    public function AcademiclListeningScore(Request $request)
    {
        //dd($request);
        $selectedOptions = urldecode($request->input('selectedOptions'));
        $questionId = $request->questionId;

        // 1. Retrieve all correct answers for the given question set
        $correctAnswers = $this->getAllCorrectAnswersForQuestionSet($request->questionSetId);

        // 2. Retrieve the selected correct answer for the given question
        $correctAnswer = $this->getCorrectAnswerForQuestion($questionId);

        // 3. Calculate the score by comparing selected options with the user's answer
        $score = $this->calculateScore($selectedOptions, $correctAnswers, $correctAnswer);

        // 4. Get the logged-in student's ID
        $studentId = Auth::guard('student')->user()->id;

        // 5. Store the score in the database
        DB::table('exam_user')->insert([
            'student_id' => $studentId,
            'question_sets_id' => $request->questionSetId,
            'score' => $score,
        ]);
        return redirect()->route('academic.reading.confirm_details');
        // return response()->json(['message' => 'Score stored successfully', 'score' => $score]);
    }

    public function GenerallListeningScore(Request $request)
    {
        // dd($request);
        $selectedOptions = urldecode($request->input('selectedOptions'));
        $questionId = $request->questionId;

        // 1. Retrieve all correct answers for the given question set
        $correctAnswers = $this->getAllCorrectAnswersForQuestionSet($request->questionSetId);

        // 2. Retrieve the selected correct answer for the given question
        $correctAnswer = $this->getCorrectAnswerForQuestion($questionId);

        // 3. Calculate the score by comparing selected options with the user's answer
        $score = $this->calculateScore($selectedOptions, $correctAnswers, $correctAnswer);

        // 4. Get the logged-in student's ID
        $studentId = Auth::guard('student')->user()->id;

        // 5. Store the score in the database
        DB::table('exam_user')->insert([
            'student_id' => $studentId,
            'question_sets_id' => $request->questionSetId,
            'score' => $score,
        ]);
        return redirect('test_score')->with('status', 'Submitted successfully');
        // return response()->json(['message' => 'Score stored successfully', 'score' => $score]);
    }

    private function getAllCorrectAnswersForQuestionSet($questionSetId)
    {
        // Retrieve all correct answers for the given question set from your database
        // Implement your database query to fetch the correct answers here
        $correctAnswers = QuestionModel::where('question_sets_id', $questionSetId)
            ->pluck('correct_answer', 'id')
            ->toArray();

        return $correctAnswers;
    }

    private function getCorrectAnswerForQuestion($questionId)
    {
        // Retrieve the correct answer for the given question from your database
        // Implement your database query to fetch the correct answer here
        $correctAnswer = QuestionModel::where('id', $questionId)->value('correct_answer');

        return $correctAnswer;
    }

    private function calculateScore($selectedOptions, $correctAnswers, $correctAnswer)
    {
        // Implement your scoring logic by comparing selectedOptions with the user's answer
        // Return the calculated score
        $selectedAnswers = explode("\n", urldecode($selectedOptions));
        $score = 0;

        foreach ($selectedAnswers as $answer) {
            // Extract the question number and user's answer
            preg_match('/Question (\d+): (.+)/', $answer, $matches);
            if (count($matches) == 3) {
                $questionNumber = $matches[1];
                $userAnswer = trim($matches[2]); // Trim user's answer

                $type = DB::table('questions')->find($questionNumber)->question_type;
                if ($type) {
                    // Check if the selected answer exists in the correct answers array
                    if (isset($correctAnswers[$questionNumber]) && $userAnswer === $correctAnswers[$questionNumber]) {
                        $score++;
                    } elseif ($questionNumber == 1 && $userAnswer === $correctAnswer) {
                        $score++;
                    }
                } else {
                    $userAnswer = strtolower($userAnswer);
                    $correctAnswers[$questionNumber] = strtolower($correctAnswers[$questionNumber]);
                    $arrayResult = explode("#", $correctAnswers[$questionNumber]);
                    if (isset($correctAnswers[$questionNumber]) && in_array($userAnswer, $arrayResult)) {
                        $score++;
                    } elseif ($questionNumber == 1 && $userAnswer === $correctAnswer) {
                        $score++;
                    }
                }
            }
        }

        return $score;
    }
    public function TestScore()
    {

        $studentId = Auth::guard('student')->user()->id;

        $data = DB::table('question_sets')
            ->leftJoin('skills', 'skills.id', '=', 'question_sets.skills_id')
            ->leftJoin('exam_user', 'question_sets.id', '=', 'exam_user.question_sets_id')
            ->leftJoin('test_title', 'test_title.id', '=', 'question_sets.title_id')
            ->where('exam_user.student_id', $studentId) // Add this line
            ->select('test_title.title as title', 'exam_user.score as score', 'skills.title as skill_title')
            ->get();
        //dd($data);
        return view('student.test_score', compact('data'));
    }

    public function AdminTestScore()
    {

        $data = DB::table('question_sets')
            ->rightJoin('skills', 'skills.id', '=', 'question_sets.skills_id')
            ->rightJoin('exam_user', 'question_sets.id', '=', 'exam_user.question_sets_id')
            ->rightJoin('test_title', 'test_title.id', '=', 'question_sets.title_id')
            ->join('students', 'students.id', '=', 'exam_user.student_id')
            ->select('exam_user.id as user_id', 'students.name as student_name', 'students.email as student_email', 'test_title.title as title', 'exam_user.score as score', 'skills.title as skill_title')
            ->orderByDesc('exam_user.id')
            ->get();
        // dd($data);
        return view('admin.student_score.index', compact('data'));
    }

    public function DestroyTestScore($id)
    {

        $item = DB::table('exam_user')->find($id);

        if (!$item) {
            return redirect()->back()->with('delete_status', 'Score not found');
        }

        DB::table('exam_user')->where('id', $id)->delete();

        return redirect()->back()->with('delete_status', 'Score deleted successfully');

    }
}
