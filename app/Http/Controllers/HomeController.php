<?php

namespace App\Http\Controllers;

use App\Models\SkillModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class HomeController extends Controller
{
    public function Academic()
    {
        $data = DB::table('question_sets')
            ->leftJoin('test_title', 'test_title.id', '=', 'question_sets.title_id')
            ->select('test_title.title as test_title', 'question_sets.*')
            ->where('question_sets.type_id', 1)
            ->where('question_sets.is_active', 1)
            ->distinct()
            ->get();

        $skillsByTitle = [];

        foreach ($data as $row) {
            $title_id = $row->title_id;
            $skills_id = $row->skills_id;

            if (!isset($skillsByTitle[$title_id])) {
                $skillsByTitle[$title_id] = [];
            }

            $skillsByTitle[$title_id][] = $skills_id;
        }

        $titleNames = [];
        $skillsNames = [];

        foreach ($skillsByTitle as $title_id => $skills) {
            $titleNames[$title_id] = $data->where('title_id', $title_id)->first()->test_title;
            $skillsNames[$title_id] = [];

            foreach ($skills as $skills_id) {
                // Fetch skills name based on skills_id (you need to define the table and column names)
                $skillsNames[$title_id][$skills_id] = SkillModel::where('id', $skills_id)->value('title');
            }
        }
        // dd($titleNames, $skillsNames, $skillsByTitle);
        return view('student.academic', compact('skillsByTitle', 'titleNames', 'skillsNames'));
    }


    public function General()
    {
        $data = DB::table('question_sets')
            ->leftJoin('test_title', 'test_title.id', '=', 'question_sets.title_id')
            ->select('test_title.title as test_title', 'question_sets.*')
            ->where('question_sets.type_id', 2)
            ->where('question_sets.is_active', 1)
            ->distinct()
            ->get();

        // Create an associative array to store skills_ids for each title_id
        $skillsByTitle = [];

        foreach ($data as $row) {
            $title_id = $row->title_id;
            $skills_id = $row->skills_id;

            if (!isset($skillsByTitle[$title_id])) {
                $skillsByTitle[$title_id] = [];
            }

            $skillsByTitle[$title_id][] = $skills_id;
        }

        $titleNames = [];
        $skillsNames = [];

        foreach ($skillsByTitle as $title_id => $skills) {
            $titleNames[$title_id] = $data->where('title_id', $title_id)->first()->test_title;
            $skillsNames[$title_id] = [];

            foreach ($skills as $skills_id) {
                // Fetch skills name based on skills_id (you need to define the table and column names)
                $skillsNames[$title_id][$skills_id] = SkillModel::where('id', $skills_id)->value('title');
            }
        }
        // dd($titleNames,$skillsNames);
        return view('student.general', compact('skillsByTitle', 'titleNames', 'skillsNames'));
    }

    public function AcademicListening($title_id, $skills_id)
    {
        $title_id = intval($title_id);
        $skills_id = intval($skills_id);
        // $type_id = 1;
        // $getQuestionSet = DB::table('question_sets')
        //     ->select('id')
        //     ->where(['skills_id' => $skills_id, 'title_id' => $title_id, 'type_id' => $type_id])
        //     ->first();

        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration
        //dd($question_set_id);
        $data = DB::table('questions')
            ->leftJoin('question_sets', 'question_sets.id', '=', 'questions.question_sets_id')
            ->leftJoin('question_options', 'question_options.questions_id', '=', 'questions.id')
            ->select('question_sets.title_id', 'question_sets.skills_id', 'question_sets.part_info', 'question_sets.audio_file', 'question_sets.id as question_set_id', 'questions.id as question_id', 'questions.title as question_title', 'questions.group_id as group_id', 'question_options.id as question_option_id', 'question_options.title as question_option') // Filter by skills_id
            ->where('questions.question_sets_id', $question_set_id)
            ->orderBy('questions.id', 'ASC')
            ->get();
        // dd($data);
        $organizedData = [];
        $grouparray = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;
            $audio_file = $row->audio_file;

            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'audio_file' => $audio_file,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }

            $questionId = $row->question_id;

            if (!$row->group_id) {
                if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {
                    $organizedData[$questionSetId]['questions'][$questionId] = [
                        'title' => $row->question_title,
                        'options' => [],
                    ];
                }

                $organizedData[$questionSetId]['questions'][$questionId]['options'][] = [
                    'option_id' => $row->question_option_id,
                    'option' => $row->question_option,
                ];
            } else {
                if (!in_array($row->group_id, $grouparray)) {
                    $grouparray[] = $row->group_id;
                    if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {

                        $grouptext = DB::table('questions_group')->find($row->group_id)->questions;

                        // Check for $dropdown and replace with select box
                        if (strpos($grouptext, '$dropdown') !== false) {
                            $grouptext = preg_replace_callback('/(\$dropdown)/', function ($matches) {
                                // Replace $dropdown with select box HTML
                                $options = ['Option 1', 'Option 2', 'Option 3']; // Replace with your options
                                $selectBox = '<select>';
                                foreach ($options as $option) {
                                    $selectBox .= '<option value="' . $option . '">' . $option . '</option>';
                                }
                                $selectBox .= '</select>';
                                return $selectBox;
                            }, $grouptext);
                        }

                        // Replace $input\d+ with input fields
                        $grouptext = preg_replace_callback('/(\$input\d+)/', function ($matches) {
                            $inputNumber = substr($matches[1], 6); // Extract the number from the variable name
                            return '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $inputNumber . '">';
                        }, json_decode($grouptext));

                        $organizedData[$questionSetId]['questions'][$questionId] = [
                            'title' => $grouptext,
                            'options' => [],
                        ];
                    }
                }
            }
        }

        //dd($organizedData);
        return view('academicExam.listening', compact('organizedData'));
    }

    public function GeneralListening($title_id, $skills_id)
    {
        $title_id = intval($title_id);
        $skills_id = intval($skills_id);
        $type_id = 2;
        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id, 'type_id' => $type_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration
        //dd($question_set_id);
        $data = DB::table('questions')
            ->leftJoin('question_sets', 'question_sets.id', '=', 'questions.question_sets_id')
            ->leftJoin('question_options', 'question_options.questions_id', '=', 'questions.id')
            ->select('question_sets.title_id', 'question_sets.skills_id', 'question_sets.part_info', 'question_sets.audio_file', 'question_sets.id as question_set_id', 'questions.id as question_id', 'questions.title as question_title', 'questions.group_id as group_id', 'question_options.id as question_option_id', 'question_options.title as question_option') // Filter by skills_id
            ->where('questions.question_sets_id', $question_set_id)
            ->orderBy('questions.id', 'ASC')
            ->get();
        // dd($data);
        $organizedData = [];
        $grouparray = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;
            $audio_file = $row->audio_file;

            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'audio_file' => $audio_file,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }

            $questionId = $row->question_id;



            if (!$row->group_id) {
                if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {
                    $organizedData[$questionSetId]['questions'][$questionId] = [
                        'title' => $row->question_title,
                        'options' => [],
                    ];
                }

                $organizedData[$questionSetId]['questions'][$questionId]['options'][] = [
                    'option_id' => $row->question_option_id,
                    'option' => $row->question_option,
                ];
            } else {
                if (!in_array($row->group_id, $grouparray)) {
                    $grouparray[] = $row->group_id;
                    if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {

                        $grouptext = DB::table('questions_group')->find($row->group_id)->questions;
                        $grouptext = preg_replace_callback('/(\$input\d+)/', function ($matches) {
                            $inputNumber = substr($matches[1], 6); // Extract the number from the variable name
                            return '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $inputNumber . '">';
                        }, json_decode($grouptext));
                        $organizedData[$questionSetId]['questions'][$questionId] = [
                            'title' => $grouptext,
                            'options' => [],
                        ];
                    }
                }
            }
        }
        //dd($organizedData);
        return view('generalExam.listening', compact('organizedData'));
    }

    public function AcademicReading($title_id, $skills_id)
    {
        $title_id = intval($title_id);
        $skills_id = intval($skills_id);

        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration

        $data = DB::table('questions')
            ->leftJoin('question_sets', 'question_sets.id', '=', 'questions.question_sets_id')
            ->leftJoin('question_options', 'question_options.questions_id', '=', 'questions.id')
            ->select('question_sets.title_id', 'question_sets.skills_id', 'question_sets.part_info', 'question_sets.id as question_set_id', 'questions.id as question_id', 'questions.question_type as questions_type', 'questions.title as question_title', 'questions.group_id as group_id', 'question_options.id as question_option_id', 'question_options.title as question_option') // Filter by skills_id
            ->where('questions.question_sets_id', $question_set_id)
            ->orderBy('questions.id', 'ASC')
            ->get();
        $organizedData = [];
        $grouparray = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;
            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }

            $questionId = $row->question_id;

            if (!$row->group_id) {
                if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {
                    $organizedData[$questionSetId]['questions'][$questionId] = [
                        'title' => $row->question_title,
                        'type' => $row->questions_type,
                        'options' => [],
                    ];
                }

                $organizedData[$questionSetId]['questions'][$questionId]['options'][] = [
                    'option_id' => $row->question_option_id,
                    'option' => $row->question_option,
                ];
            } else {
                if (!in_array($row->group_id, $grouparray)) {
                    $grouparray[] = $row->group_id;
                    if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {

                        $grouptext = DB::table('questions_group')->find($row->group_id)->questions;
                        $grouptext = preg_replace_callback('/(\$input\d+)/', function ($matches) {
                            $inputNumber = substr($matches[1], 6); // Extract the number from the variable name
                            return '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $inputNumber . '">';
                        }, json_decode($grouptext));
                        $organizedData[$questionSetId]['questions'][$questionId] = [
                            'title' => $grouptext,
                            'options' => [],
                        ];
                    }
                }
            }
        }

        // dd($grouparray);

        //dd($organizedData);

        return view('academicExam.reading', compact('organizedData'));
    }

    public function GeneralReading($title_id, $skills_id)
    {
        $title_id = intval($title_id);
        $skills_id = intval($skills_id);

        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration

        $data = DB::table('questions')
            ->leftJoin('question_sets', 'question_sets.id', '=', 'questions.question_sets_id')
            ->leftJoin('question_options', 'question_options.questions_id', '=', 'questions.id')
            ->select('question_sets.title_id', 'question_sets.skills_id', 'question_sets.part_info', 'question_sets.id as question_set_id', 'questions.id as question_id', 'questions.title as question_title', 'questions.group_id as group_id', 'question_options.id as question_option_id', 'question_options.title as question_option') // Filter by skills_id
            ->where('questions.question_sets_id', $question_set_id)
            ->orderBy('questions.id', 'ASC')
            ->get();
        $organizedData = [];

        $grouparray = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;
            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }

            $questionId = $row->question_id;

            if (!$row->group_id) {
                if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {
                    $organizedData[$questionSetId]['questions'][$questionId] = [
                        'title' => $row->question_title,
                        'options' => [],
                    ];
                }

                $organizedData[$questionSetId]['questions'][$questionId]['options'][] = [
                    'option_id' => $row->question_option_id,
                    'option' => $row->question_option,
                ];
            } else {
                if (!in_array($row->group_id, $grouparray)) {
                    $grouparray[] = $row->group_id;
                    if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {

                        $grouptext = DB::table('questions_group')->find($row->group_id)->questions;
                        $grouptext = preg_replace_callback('/(\$input\d+)/', function ($matches) {
                            $inputNumber = substr($matches[1], 6); // Extract the number from the variable name
                            return '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $inputNumber . '">';
                        }, json_decode($grouptext));
                        $organizedData[$questionSetId]['questions'][$questionId] = [
                            'title' => $grouptext,
                            'options' => [],
                        ];
                    }
                }
            }
        }

        // dd($organizedData);

        return view('generalExam.reading', compact('organizedData'));
    }

    public function AcademicWriting($title_id, $skills_id)
    {
        $title_id = intval($title_id);
        $skills_id = intval($skills_id);

        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration

        $data = DB::table('question_sets')
            ->select('title_id', 'skills_id', 'part_info', 'id as question_set_id')
            ->where('id', $question_set_id)
            ->get();

        $organizedData = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;

            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }
        }

        // dd($organizedData);
        return view('academicExam.writing', compact('organizedData'));
    }
    public function GeneralWriting($title_id, $skills_id)
    {
        $title_id = intval($title_id);
        $skills_id = intval($skills_id);

        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration

        $data = DB::table('question_sets')
            ->select('title_id', 'skills_id', 'part_info', 'id as question_set_id')
            ->where('id', $question_set_id)
            ->get();

        $organizedData = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;

            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }
        }

        return view('generalExam.writing', compact('organizedData'));
    }

    public function academicStartTest()
    {
        return view('student.academic_start_test');
    }
    public function generalStartTest()
    {
        return view('student.general_start_test');
    }

    // $validatedData = $request->validate([
    //     'name' => 'required|string|max:255',
    //     'Email' => 'required|email|unique:students',
    //     'password' => 'required|string|min:6|confirmed',
    // ]);

    // $student = new Student();
    // $student->StudentName = $validatedData['name'];
    // $student->Email = $validatedData['Email'];
    // $student->password = $validatedData['password'];
    // $student->save();

    // return response()->json(['message' => 'Student registered successfully'], 201);
    // }

    public function academicListeningConfirm()
    {
        return view('student.academic_listening_confirm_details');
    }

    public function generalListeningConfirm()
    {
        return view('student.general_listening_confirm_details');
    }

    public function TestAcademicListening()
    {
        $skills_id = 6;
        $title_id = DB::table('question_sets')->where('type_id', '=', 1)->where('skills_id', '=', $skills_id)->where('is_active', 1)->first()->title_id;


        // $type_id = 1;
        // $getQuestionSet = DB::table('question_sets')
        //     ->select('id')
        //     ->where(['skills_id' => $skills_id, 'title_id' => $title_id, 'type_id' => $type_id])
        //     ->first();

        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration
        //dd($question_set_id);
        $data = DB::table('questions')
            ->leftJoin('question_sets', 'question_sets.id', '=', 'questions.question_sets_id')
            ->leftJoin('question_options', 'question_options.questions_id', '=', 'questions.id')
            ->select('question_sets.title_id', 'question_sets.skills_id', 'question_sets.part_info', 'question_sets.audio_file', 'question_sets.id as question_set_id', 'questions.id as question_id', 'questions.title as question_title', 'questions.question_type as questions_type', 'questions.group_id as group_id', 'question_options.id as question_option_id', 'question_options.title as question_option') // Filter by skills_id
            ->where('questions.question_sets_id', $question_set_id)
            ->orderBy('questions.id', 'ASC') // Ascending order by questions.id
            ->orderBy('question_options.id', 'ASC') // Ascending order by question_options.id
            ->get();
        //dd($data);
        $organizedData = [];
        $grouparray = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;
            $audio_file = $row->audio_file;

            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'audio_file' => $audio_file,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }

            $questionId = $row->question_id;

            if (!$row->group_id) {
                if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {
                    $organizedData[$questionSetId]['questions'][$questionId] = [
                        'title' => $row->question_title,
                        'type' => $row->questions_type,
                        'options' => [],
                    ];
                }
                $organizedData[$questionSetId]['questions'][$questionId]['options'][] = [
                    'option_id' => $row->question_option_id,
                    'option' => $row->question_option,
                ];
            } else {
                if (!in_array($row->group_id, $grouparray)) {
                    $grouparray[] = $row->group_id;

                    if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {

                        $grouptext = DB::table('questions_group')->find($row->group_id)->questions;

                        $inputType = substr_count(strtolower($grouptext), '$input');

                        $dropdownType = substr_count(strtolower($grouptext), '$dropdown');

                        if ($inputType) {
                            $grouptext = preg_replace_callback('/(\$input\d+)/', function ($matches) {
                                $inputNumber = substr($matches[1], 6); // Extract the number from the variable name
                                return '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $inputNumber . '">';
                            }, json_decode($grouptext));
                        } elseif ($dropdownType) {
                            $grouptext = preg_replace_callback('/\$dropdown(\d+)@([^$]+)\$([^<]+)/', function ($matches) {
                                // Extract the dropdown details dynamically
                                $dropdownNumber = $matches[1];
                                $options = explode('@', $matches[2]);
                                $questionTitle = $matches[3];

                                $dropdownTag = '<select style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $dropdownNumber . '">';
                                // Add an empty option
                                $dropdownTag .= '<option value=""></option>';

                                foreach ($options as $option) {
                                    $dropdownTag .= '<option>' . $option . '</option>';
                                }

                                $dropdownTag .= '</select>';
                                $dropdownTag .= '<span class="question-title">' . $questionTitle . '</span>';

                                // You can use $questionTitle as needed for your application

                                return $dropdownTag;
                            }, json_decode($grouptext));
                        }

                        $organizedData[$questionSetId]['questions'][$questionId] = [
                            'title' => $grouptext,
                            'options' => [], // You might want to populate this with actual data from your application
                        ];
                        //dd($organizedData);
                    }
                }
            }
        }
        //dd($organizedData);

        return view('academicExam.listening', compact('organizedData'));
    }
    public function TestGeneralListening()
    {
        $skills_id = 7;
        $title_id = DB::table('question_sets')->where('type_id', '=', 2)->where('skills_id', '=', $skills_id)->where('is_active', 1)->first()->title_id;


        // $type_id = 1;
        // $getQuestionSet = DB::table('question_sets')
        //     ->select('id')
        //     ->where(['skills_id' => $skills_id, 'title_id' => $title_id, 'type_id' => $type_id])
        //     ->first();

        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration
        //dd($question_set_id);
        $data = DB::table('questions')
            ->leftJoin('question_sets', 'question_sets.id', '=', 'questions.question_sets_id')
            ->leftJoin('question_options', 'question_options.questions_id', '=', 'questions.id')
            ->select('question_sets.title_id', 'question_sets.skills_id', 'question_sets.part_info', 'question_sets.audio_file', 'question_sets.id as question_set_id', 'questions.id as question_id', 'questions.title as question_title', 'questions.question_type as questions_type', 'questions.group_id as group_id', 'question_options.id as question_option_id', 'question_options.title as question_option') // Filter by skills_id
            ->where('questions.question_sets_id', $question_set_id)
            ->orderBy('questions.id', 'ASC')
            ->get();
        //dd($data);
        $organizedData = [];
        $grouparray = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;
            $audio_file = $row->audio_file;

            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'audio_file' => $audio_file,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }

            $questionId = $row->question_id;

            if (!$row->group_id) {
                if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {
                    $organizedData[$questionSetId]['questions'][$questionId] = [
                        'title' => $row->question_title,
                        'type' => $row->questions_type,
                        'options' => [],
                    ];
                }
                $organizedData[$questionSetId]['questions'][$questionId]['options'][] = [
                    'option_id' => $row->question_option_id,
                    'option' => $row->question_option,
                ];
            } else {
                if (!in_array($row->group_id, $grouparray)) {
                    $grouparray[] = $row->group_id;

                    if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {

                        $grouptext = DB::table('questions_group')->find($row->group_id)->questions;

                        $inputType = substr_count(strtolower($grouptext), '$input');

                        $dropdownType = substr_count(strtolower($grouptext), '$dropdown');

                        if ($inputType) {
                            $grouptext = preg_replace_callback('/(\$input\d+)/', function ($matches) {
                                $inputNumber = substr($matches[1], 6); // Extract the number from the variable name
                                return '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $inputNumber . '">';
                            }, json_decode($grouptext));
                        } elseif ($dropdownType) {
                            $grouptext = preg_replace_callback('/\$dropdown(\d+)@([^$]+)\$([^<]+)/', function ($matches) {
                                // Extract the dropdown details dynamically
                                $dropdownNumber = $matches[1];
                                $options = explode('@', $matches[2]);
                                $questionTitle = $matches[3];

                                $dropdownTag = '<select style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $dropdownNumber . '">';
                                // Add an empty option
                                $dropdownTag .= '<option value=""></option>';

                                foreach ($options as $option) {
                                    $dropdownTag .= '<option>' . $option . '</option>';
                                }

                                $dropdownTag .= '</select>';
                                $dropdownTag .= '<span class="question-title">' . $questionTitle . '</span>';

                                // You can use $questionTitle as needed for your application

                                return $dropdownTag;
                            }, json_decode($grouptext));
                        }

                        $organizedData[$questionSetId]['questions'][$questionId] = [
                            'title' => $grouptext,
                            'options' => [], // You might want to populate this with actual data from your application
                        ];
                        //dd($organizedData);
                    }
                }
            }
        }
        //dd($organizedData);

        return view('generalExam.listening', compact('organizedData'));
    }



    public function academicReadingConfirm()
    {
        return view('student.academic_reading_confirm_details');
    }
    public function generalReadingConfirm()
    {
        return view('student.general_reading_confirm_details');
    }

    public function TestAcademicReading()
    {
        $skills_id = 2;
        $title_id = DB::table('question_sets')->where('type_id', '=', 1)->where('skills_id', '=', $skills_id)->where('is_active', 1)->first()->title_id;

        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration

        $data = DB::table('questions')
            ->leftJoin('question_sets', 'question_sets.id', '=', 'questions.question_sets_id')
            ->leftJoin('question_options', 'question_options.questions_id', '=', 'questions.id')
            ->select('question_sets.title_id', 'question_sets.skills_id', 'question_sets.part_info', 'question_sets.id as question_set_id', 'questions.id as question_id', 'questions.question_type as questions_type', 'questions.title as question_title', 'questions.group_id as group_id', 'question_options.id as question_option_id', 'question_options.title as question_option') // Filter by skills_id
            ->where('questions.question_sets_id', $question_set_id)
            ->orderBy('questions.id', 'ASC')
            ->get();
        $organizedData = [];
        $grouparray = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;
            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }

            $questionId = $row->question_id;
            if (!$row->group_id) {
                if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {
                    $organizedData[$questionSetId]['questions'][$questionId] = [
                        'title' => $row->question_title,
                        'type' => $row->questions_type,
                        'options' => [],
                    ];
                }
                $organizedData[$questionSetId]['questions'][$questionId]['options'][] = [
                    'option_id' => $row->question_option_id,
                    'option' => $row->question_option,
                ];
            } else {
                if (!in_array($row->group_id, $grouparray)) {
                    $grouparray[] = $row->group_id;

                    if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {

                        $grouptext = DB::table('questions_group')->find($row->group_id)->questions;

                        $inputType = substr_count(strtolower($grouptext), '$input');

                        $dropdownType = substr_count(strtolower($grouptext), '$dropdown');

                        if ($inputType) {
                            $grouptext = preg_replace_callback('/(\$input\d+)/', function ($matches) {
                                $inputNumber = substr($matches[1], 6); // Extract the number from the variable name
                                return '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $inputNumber . '">';
                            }, json_decode($grouptext));
                        } elseif ($dropdownType) {
                            $grouptext = preg_replace_callback('/\$dropdown(\d+)@([^$]+)\$([^<]+)/', function ($matches) {
                                // Extract the dropdown details dynamically
                                $dropdownNumber = $matches[1];
                                $options = explode('@', $matches[2]);
                                $questionTitle = $matches[3];

                                $dropdownTag = '<select style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $dropdownNumber . '">';
                                // Add an empty option
                                $dropdownTag .= '<option value=""></option>';

                                foreach ($options as $option) {
                                    $dropdownTag .= '<option>' . $option . '</option>';
                                }

                                $dropdownTag .= '</select>';
                                $dropdownTag .= '<span class="question-title">' . $questionTitle . '</span>';

                                // You can use $questionTitle as needed for your application

                                return $dropdownTag;
                            }, json_decode($grouptext));
                        }

                        $organizedData[$questionSetId]['questions'][$questionId] = [
                            'title' => $grouptext,
                            'options' => [], // You might want to populate this with actual data from your application
                        ];
                        //dd($organizedData);
                    }
                }
            }

            // if (!$row->group_id) {
            //     if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {
            //         $organizedData[$questionSetId]['questions'][$questionId] = [
            //             'title' => $row->question_title,
            //             'type' => $row->questions_type,
            //             'options' => [],
            //         ];
            //     }

            //     $organizedData[$questionSetId]['questions'][$questionId]['options'][] = [
            //         'option_id' => $row->question_option_id,
            //         'option' => $row->question_option,
            //     ];
            // } else {
            //     if (!in_array($row->group_id, $grouparray)) {
            //         $grouparray[] = $row->group_id;
            //         if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {

            //             $grouptext = DB::table('questions_group')->find($row->group_id)->questions;
            //             $grouptext = preg_replace_callback('/(\$input\d+)/', function ($matches) {
            //                 $inputNumber = substr($matches[1], 6); // Extract the number from the variable name
            //                 return '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $inputNumber . '">';
            //             }, json_decode($grouptext));
            //             $organizedData[$questionSetId]['questions'][$questionId] = [
            //                 'title' => $grouptext,
            //                 'options' => [],
            //             ];
            //         }
            //     }
            // }
        }

        // dd($grouparray);

        //dd($organizedData);

        return view('academicExam.reading', compact('organizedData'));
    }
    public function TestGeneralReading()
    {
        $skills_id = 3;
        $title_id = DB::table('question_sets')->where('type_id', '=', 2)->where('skills_id', '=', $skills_id)->where('is_active', 1)->first()->title_id;

        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration

        $data = DB::table('questions')
            ->leftJoin('question_sets', 'question_sets.id', '=', 'questions.question_sets_id')
            ->leftJoin('question_options', 'question_options.questions_id', '=', 'questions.id')
            ->select('question_sets.title_id', 'question_sets.skills_id', 'question_sets.part_info', 'question_sets.id as question_set_id', 'questions.id as question_id', 'questions.question_type as questions_type', 'questions.title as question_title', 'questions.group_id as group_id', 'question_options.id as question_option_id', 'question_options.title as question_option') // Filter by skills_id
            ->where('questions.question_sets_id', $question_set_id)
            ->orderBy('questions.id', 'ASC')
            ->get();
        $organizedData = [];
        $grouparray = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;
            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }

            $questionId = $row->question_id;
            if (!$row->group_id) {
                if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {
                    $organizedData[$questionSetId]['questions'][$questionId] = [
                        'title' => $row->question_title,
                        'type' => $row->questions_type,
                        'options' => [],
                    ];
                }
                $organizedData[$questionSetId]['questions'][$questionId]['options'][] = [
                    'option_id' => $row->question_option_id,
                    'option' => $row->question_option,
                ];
            } else {
                if (!in_array($row->group_id, $grouparray)) {
                    $grouparray[] = $row->group_id;

                    if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {

                        $grouptext = DB::table('questions_group')->find($row->group_id)->questions;

                        $inputType = substr_count(strtolower($grouptext), '$input');

                        $dropdownType = substr_count(strtolower($grouptext), '$dropdown');

                        if ($inputType) {
                            $grouptext = preg_replace_callback('/(\$input\d+)/', function ($matches) {
                                $inputNumber = substr($matches[1], 6); // Extract the number from the variable name
                                return '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $inputNumber . '">';
                            }, json_decode($grouptext));
                        } elseif ($dropdownType) {
                            $grouptext = preg_replace_callback('/\$dropdown(\d+)@([^$]+)\$([^<]+)/', function ($matches) {
                                // Extract the dropdown details dynamically
                                $dropdownNumber = $matches[1];
                                $options = explode('@', $matches[2]);
                                $questionTitle = $matches[3];

                                $dropdownTag = '<select style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $dropdownNumber . '">';
                                // Add an empty option
                                $dropdownTag .= '<option value=""></option>';

                                foreach ($options as $option) {
                                    $dropdownTag .= '<option>' . $option . '</option>';
                                }

                                $dropdownTag .= '</select>';
                                $dropdownTag .= '<span class="question-title">' . $questionTitle . '</span>';

                                // You can use $questionTitle as needed for your application

                                return $dropdownTag;
                            }, json_decode($grouptext));
                        }

                        $organizedData[$questionSetId]['questions'][$questionId] = [
                            'title' => $grouptext,
                            'options' => [], // You might want to populate this with actual data from your application
                        ];
                        //dd($organizedData);
                    }
                }
            }

            // if (!$row->group_id) {
            //     if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {
            //         $organizedData[$questionSetId]['questions'][$questionId] = [
            //             'title' => $row->question_title,
            //             'type' => $row->questions_type,
            //             'options' => [],
            //         ];
            //     }

            //     $organizedData[$questionSetId]['questions'][$questionId]['options'][] = [
            //         'option_id' => $row->question_option_id,
            //         'option' => $row->question_option,
            //     ];
            // } else {
            //     if (!in_array($row->group_id, $grouparray)) {
            //         $grouparray[] = $row->group_id;
            //         if (!isset($organizedData[$questionSetId]['questions'][$questionId])) {

            //             $grouptext = DB::table('questions_group')->find($row->group_id)->questions;
            //             $grouptext = preg_replace_callback('/(\$input\d+)/', function ($matches) {
            //                 $inputNumber = substr($matches[1], 6); // Extract the number from the variable name
            //                 return '<input style="padding: 5px 10px; border-radius: 50px; border: 2px solid gray;text-align:center" type="text" data-num="' . $inputNumber . '">';
            //             }, json_decode($grouptext));
            //             $organizedData[$questionSetId]['questions'][$questionId] = [
            //                 'title' => $grouptext,
            //                 'options' => [],
            //             ];
            //         }
            //     }
            // }
        }

        // dd($grouparray);

        //dd($organizedData);

        return view('generalExam.reading', compact('organizedData'));
    }

    public function academicWritingConfirm()
    {
        return view('student.academic_writing_confirm_details');
    }
    public function generalWritingConfirm()
    {
        return view('student.general_writing_confirm_details');
    }

    public function TestAcademicWriting()
    {
        $skills_id = 4;
        $title_id = DB::table('question_sets')->where('type_id', '=', 1)->where('skills_id', '=', $skills_id)->where('is_active', 1)->first()->title_id;


        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration

        $data = DB::table('question_sets')
            ->select('title_id', 'skills_id', 'part_info', 'id as question_set_id')
            ->where('id', $question_set_id)
            ->get();

        $organizedData = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;

            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }
        }

        // dd($organizedData);
        return view('academicExam.writing', compact('organizedData'));
    }
    public function TestGeneralWriting()
    {
        $skills_id = 5;
        $title_id = DB::table('question_sets')->where('type_id', '=', 2)->where('skills_id', '=', $skills_id)->where('is_active', 1)->first()->title_id;


        $getQuestionSet = DB::table('question_sets')
            ->select('id', 'exam_duration')
            ->where(['skills_id' => $skills_id, 'title_id' => $title_id])
            ->first();

        if (!$getQuestionSet) {
            return '';
        }

        $question_set_id = $getQuestionSet->id;
        $exam_duration = $getQuestionSet->exam_duration; // Added to capture the exam_duration

        $data = DB::table('question_sets')
            ->select('title_id', 'skills_id', 'part_info', 'id as question_set_id')
            ->where('id', $question_set_id)
            ->get();

        $organizedData = [];

        foreach ($data as $row) {
            $questionSetId = $row->question_set_id;

            if (!isset($organizedData[$questionSetId])) {
                $organizedData[$questionSetId] = [
                    'question_set_id' => $questionSetId,
                    'title_id' => $title_id,
                    'skills_id' => $skills_id,
                    'part_info' => $row->part_info,
                    'exam_duration' => $exam_duration,
                    'questions' => [],
                ];
            }
        }

        // dd($organizedData);
        return view('generalExam.writing', compact('organizedData'));
    }
}
