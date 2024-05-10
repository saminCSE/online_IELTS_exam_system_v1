<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionModel;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionOptionModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tests = DB::table('test_title')
            ->select('id', 'title')
            ->get();
        $skills = DB::table('skills')
            ->select('id', 'title')


            ->whereNotIn('id', [4, 5]) // Exclude skills_id 4 and 5 [Writing skills]


            ->whereNotIn('id', [4, 5]) // Exclude skills_id 4 and 5 [Writing skills]

            ->get();

        $item = DB::table('questions as q')
            ->leftJoin('question_options as qo', 'qo.questions_id', '=', 'q.id')
            ->leftJoin('question_sets as qs', 'qs.id', '=', 'q.question_sets_id')
            ->leftJoin('test_title as tt', 'tt.id', '=', 'qs.title_id')
            ->leftJoin('skills as s', 's.id', '=', 'qs.skills_id')
            ->select(
                'q.id',
                'tt.id as test_id',
                DB::raw('MAX(tt.title) as test_title'),
                // Use MAX() or another appropriate aggregate function
                DB::raw('MAX(s.id) as skill_id'),
                DB::raw('MAX(s.title) as skill_name'),
                DB::raw('MAX(q.title) as question_title'),
                DB::raw('GROUP_CONCAT(qo.title SEPARATOR ";") as option_title'),
                DB::raw('MAX(q.correct_answer) as correct_answer'),
                // Assuming an aggregate function is appropriate
                DB::raw('MAX(q.is_active) as is_active'),

                DB::raw('MAX(q.group_id) as group_id'),
            )
            
            ->groupBy('q.id', 'tt.id')
            ->get();

        return view('admin.questions.index', compact('tests', 'skills', 'item'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_active = CommonController::ActiveStatus();
        $type = CommonController::AnswerType();

        $sets = DB::table('question_sets')
            ->leftJoin('test_title', 'test_title.id', '=', 'question_sets.title_id')
            ->leftJoin('skills', 'skills.id', '=', 'question_sets.skills_id')
            ->whereNotIn('question_sets.skills_id', [4, 5]) // Exclude skills_id 4 and 5
            ->select('question_sets.id', 'test_title.title as title', 'skills.title as skills_title')
            ->orderByRaw("FIELD(test_title.title, 'Academic', 'General')") // Order by Academic first, then General
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->title . ' - ' . $item->skills_title];
            })
            ->prepend('Select Question Set...', '');

        $set = $sets->toArray();

        return view('admin.questions.create', compact('type', 'is_active', 'set'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function storeSummernoteImages($content)
    {
        // Extract image references (assuming images have src attribute)
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $matches);
        $imageReferences = $matches[1];

        // Iterate over the image references
        foreach ($imageReferences as $imageReference) {
            // Check if the image is base64-encoded
            if (strpos($imageReference, 'data:image') === 0) {
                // Decode and save the base64-encoded image
                $base64Data = substr($imageReference, strpos($imageReference, ',') + 1);
                $imageData = base64_decode($base64Data);

                // Generate a unique filename for each image
                $filename = 'image_' . uniqid() . '.png';

                // Save the image to the first storage directory
                $storagePath1 = storage_path('app/public/img/');
                $filePath1 = $storagePath1 . $filename;
                $this->saveImageToStorage($imageData, $filePath1, $imageReference, $content, asset('storage/img/' . $filename));

                // Save the image to the second storage directory
                $storagePath2 = public_path('storage/img/');
                $filePath2 = $storagePath2 . $filename;
                $this->saveImageToStorage($imageData, $filePath2, $imageReference, $content, asset('storage/img/' . $filename));
            }
        }

        // Return the modified content
        return $content;
    }

    private function saveImageToStorage($imageData, $filePath, $imageReference, &$content, $newImageReference)
    {
        // Ensure the directory exists
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0775, true);
        }

        // Save the image to the directory
        if (file_put_contents($filePath, $imageData)) {
            // Replace the original image reference with the new filename
            $content = str_replace($imageReference, $newImageReference, $content);
        } else {
            // Log an error if the file couldn't be saved
            Log::error("Failed to save image file: " . basename($filePath));
        }
    }


    public function store(Request $request)
    {
        // Begin Transaction
        DB::beginTransaction();

        // Create a new question
        $question = new QuestionModel();
        $question->question_sets_id = $request->question_sets_id;
        $question->question_type = $request->question_type;
        $question->group_id = $request->group_id;
        $question->title = $request->input('title');
        $question->is_active = $request->is_active;

        // Save the question
        $question->save();

        // Check if options are provided and not empty
        if ($request->has('options') && is_array($request->options)) {
            $options = $request->input('options');

            // Check question type and perform actions accordingly
            if ($question->question_type == 1 || $question->question_type == 2) {
                $correctAnswer = $request->correct_answer;

                // Save the correct answer for types 1 or 2
                $question->correct_answer = $correctAnswer;
                $question->save();

                foreach ($options as $option) {
                    $questionOption = new QuestionOptionModel();
                    $questionOption->questions_id = $question->id;
                    $questionOption->title = $option;

                    if ($option === $correctAnswer) {
                        $questionOption->correct_answer = 1;
                    } else {
                        $questionOption->correct_answer = 0;
                    }

                    $questionOption->save();
                }
            } elseif ($question->question_type == 4) {
                $correctAnswerIndex = (int) $request->correct_option - 1; // Assuming 'correct_option' is the name of your radio button

                foreach ($options as $index => $option) {
                    $optionContent = $option;
                    $optionReferences = $this->storeSummernoteImages($optionContent);

                    // Save Summernote content references for each option
                    $questionOption = new QuestionOptionModel();
                    $questionOption->questions_id = $question->id;
                    $questionOption->title = $optionReferences;
                    $questionOption->correct_answer = ($index === $correctAnswerIndex) ? 1 : 0;
                    $questionOption->save();

                    // Save correct answer image name from selected option
                    if ($questionOption->correct_answer) {
                        $question->correct_answer = $optionReferences; // Save the full image name
                        $question->save(); // Update the question model with correct answer image name
                    }
                }
            }
        } else {
            // No options provided, use the correct_answer input field directly
            $question->correct_answer = $request->input('correct_answer');
            $question->save();
        }

        // dd($question->correct_answer);
        // Commit Transaction
        DB::commit();

        return redirect()->route('questions.index')->with('success', 'Question created successfully');
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
    public function edit(QuestionModel $question)
    {
        $is_active = CommonController::ActiveStatus();
        $type = CommonController::AnswerType();

        // Fetch question sets
        $sets = DB::table('question_sets')
            ->leftJoin('test_title', 'test_title.id', '=', 'question_sets.title_id')
            ->leftJoin('skills', 'skills.id', '=', 'question_sets.skills_id')
            ->whereNotIn('question_sets.skills_id', [4, 5])
            ->select('question_sets.id', 'test_title.title as title', 'skills.title as skills_title')
            ->orderByRaw("FIELD(test_title.title, 'Academic', 'General')")
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->title . ' - ' . $item->skills_title];
            })
            ->prepend('Select Question Set...', '');

        $set = $sets->toArray();

        // dd($question->question_type);

        // Fetch the options for the question
        if ($question->question_type == 1 || $question->question_type == 2 || $question->question_type == null) {
            // Fetch and format the options for types 1 or 2
            $options = QuestionOptionModel::where('questions_id', $question->id)
                ->get()
                ->map(function ($option) {
                    return [
                        'text' => $option->title,
                        'isCorrect' => $option->correct_answer
                    ];
                });

            // dd($question->correct_answer);

            return view('admin.questions.create')->with([
                'item' => $question,
                'is_active' => $is_active,
                'type' => $type,
                'set' => $set,
                'options' => $options,
                'isEdit' => true
            ]);
        } elseif ($question->question_type == 4) {
            // Fetch the options for type 4
            $options = QuestionOptionModel::where('questions_id', $question->id)->get();

            // Process Summernote images in question title
            $question->title = $this->storeSummernoteImages($question->title);

            // Process Summernote images in each option
            foreach ($options as $option) {
                $option->title = $this->storeSummernoteImages($option->title);
            }

            // Format options for the view
            $formattedOptions = $options->map(function ($option) {
                return [
                    'text' => $option->title,
                    'isCorrect' => $option->correct_answer,
                ];
            });

            // Pass question type to the view
            $questionType = $question->question_type;

            return view('admin.questions.create')->with([
                'item' => $question,
                'is_active' => $is_active,
                'type' => $type,
                'set' => $set,
                'options' => $formattedOptions,
                'isEdit' => true,
                'questionType' => $questionType,
            ]);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, QuestionModel $question)
    {
        if ($question->question_type == 1 || $question->question_type == 2 || $question->question_type == null) {
            // Update the question fields for types 1 or 2
            $question->update([
                'question_sets_id' => $request->question_sets_id,
                'question_type' => $request->question_type,
                'group_id' => $request->group_id,
                'title' => $request->title,
                'correct_answer' => $request->correct_answer,
                'is_active' => $request->is_active,
            ]);

            // Update question options
            if ($request->has('options') && is_array($request->options)) {
                // Delete existing options for the question
                QuestionOptionModel::where('questions_id', $question->id)->delete();

                // Insert new options
                foreach ($request->options as $option) {
                    $questionOption = new QuestionOptionModel();
                    $questionOption->questions_id = $question->id;
                    $questionOption->title = $option;
                    $questionOption->correct_answer = ($option === $request->correct_answer) ? 1 : 0;
                    $questionOption->save();
                }
            }

            // dd($question->correct_answer);

            return redirect()->route('questions.index')->with('success', 'Question updated successfully');
        } elseif ($question->question_type == 4) {
            // Update the question fields for type 4
            $question->update([
                'question_sets_id' => $request->input('question_sets_id'),
                'question_type' => $request->input('question_type'),
                'group_id' => $request->input('group_id'),
                'title' => $this->storeSummernoteImages($request->input('title')),
                'is_active' => $request->input('is_active'),
            ]);

            // Find the correct answer option based on the new title
            $correctAnswerOption = QuestionOptionModel::where('questions_id', $question->id)
                ->where('title', $request->input('correct_answer'))
                ->first();

            // Update or delete existing question images
            $this->updateOrDeleteQuestionImages($question, $request->input('title'));

            // Update or delete question options
            if ($request->has('options') && is_array($request->options)) {
                // Fetch existing options for the question
                $existingOptions = QuestionOptionModel::where('questions_id', $question->id)->get();

                // Check if the correct answer has changed to a new option
                if ($correctAnswerOption) {
                    $question->correct_answer = $correctAnswerOption->title;
                } else {
                    // If the correct answer is not found, reset it
                    $question->correct_answer = null;
                }

                // Save the changes to the question model
                $question->save();

                // Compare existing and new options to update or delete
                foreach ($existingOptions as $existingOption) {
                    // Process Summernote images in option title
                    $existingOption->title = $this->storeSummernoteImages($existingOption->title);

                    // Check if the option is present in the new data
                    $found = false;
                    foreach ($request->options as $newOption) {
                        if ($newOption === $existingOption->title) {
                            $found = true;
                            break;
                        }
                    }

                    if (!$found) {
                        // If the existing option is not in the new data, delete it and its images
                        $this->deleteOptionImages($existingOption);
                        $existingOption->delete();
                    }
                }

                // Insert new options
                foreach ($request->options as $newOption) {
                    // Check if the new option already exists
                    $existingOption = $existingOptions->firstWhere('title', $newOption);

                    if (!$existingOption) {
                        // If the new option does not exist, create it
                        $questionOption = new QuestionOptionModel();
                        $questionOption->questions_id = $question->id;
                        $questionOption->title = $this->storeSummernoteImages($newOption);
                        $questionOption->correct_answer = ($newOption === $request->input('correct_answer')) ? 1 : 0;
                        $questionOption->save();

                        // Update the correct answer field in the question model if this is the correct answer
                        if ($questionOption->correct_answer) {
                            $question->correct_answer = $questionOption->title;
                            $question->save();
                        }
                    }
                }
            }
            // dd($question->correct_answer);

            return redirect()->route('questions.index')->with('success', 'Question updated successfully');
        } else {
            // Handle other question types or no type found
            // You can customize this part based on your requirements
            return redirect()->route('questions.index')->with('error', 'Invalid question type or type not found');
        }
    }


    /**
     * Update or delete image files associated with a question.
     *
     * @param  \App\Models\QuestionModel  $question
     * @param  string  $newTitle
     */
    // private function updateOrDeleteQuestionImages(QuestionModel $question, $newTitle)
    // {
    //     // Extract the filename from the new title
    //     $newFilename = basename($newTitle);

    //     // Extract the filename from the correct_answer field
    //     $existingFilename = basename($question->correct_answer);

    //     // Check if the filenames are different
    //     if ($newFilename !== $existingFilename) {
    //         // If different, delete the existing image file
    //         $storagePath1 = storage_path('app/public/img/') . $existingFilename;
    //         $storagePath2 = public_path('storage/img/') . $existingFilename;

    //         if (file_exists($storagePath1)) {
    //             unlink($storagePath1);
    //         }

    //         if (file_exists($storagePath2)) {
    //             unlink($storagePath2);
    //         }
    //     }
    // }

    private function updateOrDeleteQuestionImages(QuestionModel $question, $newTitle)
    {
        // Extract the filename from the new title
        $newFilename = basename($newTitle);

        // Extract the filename from the correct_answer field
        $existingFilename = basename($question->correct_answer);

        // Check if the filenames are different and the existing filename is not empty
        if ($newFilename !== $existingFilename && $existingFilename !== '') {
            // If different and the existing filename is not empty, delete the existing image file
            $storagePath1 = storage_path('app/public/img/') . $existingFilename;
            $storagePath2 = public_path('storage/img/') . $existingFilename;

            if (file_exists($storagePath1)) {
                unlink($storagePath1);
            }

            if (file_exists($storagePath2)) {
                unlink($storagePath2);
            }
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
        try {
            // Fetch the question and its options
            $question = QuestionModel::findOrFail($id);
            $options = QuestionOptionModel::where('questions_id', $id)->get();

            // Process Summernote images in question title
            $question->title = $this->storeSummernoteImages($question->title);

            // Begin Transaction
            DB::beginTransaction();

            // Delete associated options and their images
            foreach ($options as $option) {
                // Process Summernote images in option title
                $option->title = $this->storeSummernoteImages($option->title);

                // Delete image files associated with the option
                $this->deleteOptionImages($option);
            }

            // Delete associated options
            QuestionOptionModel::where('questions_id', $id)->delete();

            // Delete the question and its images
            $this->deleteQuestionImages($question);
            $question->delete();

            // Commit Transaction
            DB::commit();

            return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
        } catch (\Exception $e) {
            // Rollback Transaction
            DB::rollback();

            return redirect()->route('questions.index')->with('error', 'Error occurred while deleting the question');
        }
    }

    /**
     * Delete image files associated with a question.
     *
     * @param  \App\Models\QuestionModel  $question
     */
    private function deleteQuestionImages(QuestionModel $question)
    {
        // Extract the filename from the correct_answer field
        $filename = basename($question->correct_answer);

        // Define the storage paths
        $storagePath1 = storage_path('app/public/img/') . $filename;
        $storagePath2 = public_path('storage/img/') . $filename;

        // Delete the image file if it exists in the first storage directory
        if (file_exists($storagePath1)) {
            unlink($storagePath1);
        }

        // Delete the image file if it exists in the second storage directory
        if (file_exists($storagePath2)) {
            unlink($storagePath2);
        }
    }

    /**
     * Delete image files associated with a question option.
     *
     * @param  \App\Models\QuestionOptionModel  $option
     */
    private function deleteOptionImages(QuestionOptionModel $option)
    {
        // Extract image references from the option title
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $option->title, $matches);
        $imageReferences = $matches[1];

        // Iterate over the image references
        foreach ($imageReferences as $imageReference) {
            // Extract the filename from the image reference
            $filename = basename($imageReference);

            // Define the storage paths
            $storagePath1 = storage_path('app/public/img/') . $filename;
            $storagePath2 = public_path('storage/img/') . $filename;

            // Delete the image file if it exists in the first storage directory
            if (file_exists($storagePath1)) {
                unlink($storagePath1);
            }

            // Delete the image file if it exists in the second storage directory
            if (file_exists($storagePath2)) {
                unlink($storagePath2);
            }
        }
    }
}
