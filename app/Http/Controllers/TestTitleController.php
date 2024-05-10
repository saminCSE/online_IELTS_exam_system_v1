<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\QuestionModel;
use App\Models\TestTitleModel;
use App\Models\QuestionSetModel;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionOptionModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TestTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = TestTitleModel::get();
        return view('admin.test_title.index', compact('item'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.test_title.create');
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
            $user = TestTitleModel::create($data);
            if (!$user) {
                Session::flash('error', 'An error occurred');
                return redirect()->route('testTitle.create');
            }

            Session::flash('status', 'New Title Created Successfully');
            return redirect()->route('testTitle.index');
        } catch (Exception $e) {
            // Handle other exceptions
            Session::flash('error', 'An error occurred: ' . $e->getMessage());
            return redirect()->route('testTitle.create'); // Redirect back to the batch index page with an error message
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
    public function edit(TestTitleModel $testTitle)
    {
        return view('admin.test_title.create')->with(['item' => $testTitle]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestTitleModel $testTitle)
    {
        try {
            $testTitle->update($request->all());
            return redirect()->route('testTitle.index')->with('status', 'Title Update Successfully');
        } catch (Exception $e) {
            // Handle exceptions if any occur during the update
            Session::flash('error', 'An error occurred: ' . $e->getMessage());
            return redirect()->route('testTitle.index'); // Redirect back to the batch index page with an error message
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestTitleModel $testTitle)
    {
        // dd($testTitle);
        // $testTitle->delete();
        // return redirect()
        //     ->back()
        //     ->with('delete_status', 'Test Title Delete Successfully');
        try {
            // Begin Transaction
            DB::beginTransaction();

            // Fetch the test title along with its question sets
            $testTitleWithSets = TestTitleModel::with('questionSets')->findOrFail($testTitle->id);
            // dd($testTitleWithSets);

            foreach ($testTitleWithSets->questionSets as $questionSet) {
                // Fetch questions for each question set
                $questions = QuestionModel::where('question_sets_id', $questionSet->id)->get();

                foreach ($questions as $question) {
                    // Delete options for each question
                    QuestionOptionModel::where('questions_id', $question->id)->delete();

                    // Delete group questions, assuming they are related by question_id in questions_group table
                    DB::table('questions_group')->where('id', $question->id)->delete();

                    // Delete the question
                    $question->delete();
                }

                // Delete the question set
                $questionSet->delete();
            }

            // Delete the test title
            $testTitle->delete();

            // Commit Transaction
            DB::commit();

            return redirect()->back()->with('delete_status', 'Test Title and related entities deleted successfully.');
        } catch (\Exception $e) {
            // Rollback Transaction
            DB::rollback();

            // Log the error message for debugging
            Log::error('Error occurred while deleting test title: ' . $e->getMessage());

            // Return a more detailed error message
            return redirect()->back()->with('error', 'Error occurred while deleting the test title: ' . $e->getMessage());

            // return redirect()->back()->with('error', 'Error occurred while deleting the test title');
        }
    }
}
