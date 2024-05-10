<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AnswerSubmitController;
use App\Http\Controllers\ExamSkillController;
use App\Http\Controllers\ExamTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionGroupController;
use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\QuestionSetController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\StudentManageController;
use App\Http\Controllers\TestScoreController;
use App\Http\Controllers\TestTitleController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'admin'], function () {
    Route::get('/AdminDashboard', [AdminController::class, 'AdminHome'])->name('AdminDashboard');
    Route::get('/logout/admin', [AdminLoginController::class, 'logout'])->name('admin_logout');
    Route::resource('skills', ExamSkillController::class);
    Route::resource('types', ExamTypeController::class);
    Route::resource('questions_set', QuestionSetController::class);
    Route::post('fetch-skills', [QuestionSetController::class, 'fetchSkills'])->name('skill_fetch');
    Route::resource('questions', QuestionController::class);
    Route::resource('questions_option', QuestionOptionController::class);
    Route::post('/upload-image', [QuestionSetController::class, 'uploadImage'])->name('image_uploading');
    Route::resource('testTitle', TestTitleController::class);
    Route::post('/sets/update', [QuestionSetController::class, 'SetStatusUpdate'])->name('sets_update');
    Route::get('/sets/inactive', [QuestionSetController::class, 'setInactive'])->name('set.inactive');
    Route::get('/sets/active', [QuestionSetController::class, 'setActive'])->name('set.active');
    Route::get('/questions_group', [QuestionGroupController::class, 'QuestionGroup'])->name('questions_group.index');
    Route::get('/question_group/add', [QuestionGroupController::class, 'CreateQuestionGroup'])->name('questions_group.create');
    Route::post('/store-question-group', [QuestionGroupController::class, 'store'])->name('store-question-group');
    Route::get('/admin_test_score', [TestScoreController::class, 'AdminTestScore'])->name('admin_test_score');
    Route::delete('/delete_test_score/{id}', [TestScoreController::class, 'DestroyTestScore'])->name('delete_test_score.delete_test_score_delete');
    Route::get('/writting_test', [AnswerSubmitController::class, 'WrittingAnswer'])->name('writting_test');
    Route::post('/score/update', [AnswerSubmitController::class, 'update'])->name('update_writting_score');
    Route::get('/question_group/add', [QuestionGroupController::class, 'CreateQuestionGroup'])->name('questions_group.create');
    Route::post('/store-question-group', [QuestionGroupController::class, 'store'])->name('store-question-group');
    Route::get('/question_group_list', [QuestionGroupController::class, 'questionGroupList'])->name('questions_group.question_group_list');
    Route::get('/question_group/{id}/edit', [QuestionGroupController::class, 'questionGroupEdit'])->name('questions_group.question_group_edit');
    Route::post('/question_group/update/{id}', [QuestionGroupController::class, 'questionGroupUpdate'])->name('questions_group.question_group_update');
    Route::delete('/question_group/delete/{id}', [QuestionGroupController::class, 'questionGroupDelete'])->name('questions_group.question_group_delete');
    Route::get('/candidate/list', [StudentManageController::class, 'manageCandidate'])->name('candidate_list');
    Route::get('/candidate/add', [StudentManageController::class, 'addCandidateNumber'])->name('add_candidatenumber');
    Route::post('/candidate/store', [StudentManageController::class, 'candidateStore'])->name('store_candidate');
    Route::post('/candidate/update', [StudentManageController::class, 'candidateStatusUpdate'])->name('candidatestatus_update');
});
Route::group(['middleware' => 'student'], function () {

    Route::get('/studentDashboard', function () {
        return view('student.dashboard');
    })->name('studentDashboard');

    Route::get('/logout/student', [StudentLoginController::class, 'logout'])->name('student_logout');
    Route::get('/academic', [HomeController::class, 'Academic'])->name('academic');
    Route::get('/general', [HomeController::class, 'General'])->name('general');

    Route::get('/listening/{title_id}/{skills_id}', [HomeController::class, 'AcademicListening'])->name('listening');
    Route::get('/reading/{title_id}/{skills_id}', [HomeController::class, 'AcademicReading'])->name('reading');
    Route::get('/writing/{title_id}/{skills_id}', [HomeController::class, 'AcademicWriting'])->name('writing');

    Route::get('/listening-general/{title_id}/{skills_id}', [HomeController::class, 'GeneralListening'])->name('listening_general');
    Route::get('/reading-general/{title_id}/{skills_id}', [HomeController::class, 'GeneralReading'])->name('reading_general');
    Route::get('/writing-general/{title_id}/{skills_id}', [HomeController::class, 'GeneralWriting'])->name('writing_general');
    Route::post('/store-reading-test-score', [TestScoreController::class, 'AcademicReadingScore'])->name('store-reading-test-score');
    Route::post('/general-reading-test-score', [TestScoreController::class, 'GeneralReadingScore'])->name('general-reading-test-score');
    Route::post('/academic-listening-test-score', [TestScoreController::class, 'AcademiclListeningScore'])->name('academic-listening-test-score');
    Route::post('/general-listening-test-score', [TestScoreController::class, 'GenerallListeningScore'])->name('general-listening-test-score');
    // Route::get('/test_score', [TestScoreController::class, 'TestScore'])->name('test_score');
    Route::get('/test_score', [TestScoreController::class, 'TestScore'])->name('test_score');
    Route::post('/submit_writting_answer', [AnswerSubmitController::class, 'SubmitWrittingAnswer'])->name('submit_writting_answer');
    Route::get('/test/start/academic', [HomeController::class, 'academicStartTest'])->name('academic_start_test');
    Route::get('/academic/listening/confirm_details', [HomeController::class, 'academicListeningConfirm'])->name('academic.listening.confirm_details');
    Route::get('/general/listening/confirm_details', [HomeController::class, 'generalListeningConfirm'])->name('general.listening.confirm_details');
    Route::get('/test/start/academic/listening', [HomeController::class, 'TestAcademicListening'])->name('start.academic.listening');
    Route::get('/test/start/general/listening', [HomeController::class, 'TestGeneralListening'])->name('start.general.listening');
    Route::get('/academic/reading/confirm_details', [HomeController::class, 'academicReadingConfirm'])->name('academic.reading.confirm_details');
    Route::get('/general/reading/confirm_details', [HomeController::class, 'generalReadingConfirm'])->name('general.reading.confirm_details');
    Route::get('/test/start/academic/reading', [HomeController::class, 'TestAcademicReading'])->name('start.academic.reading');
    Route::get('/test/start/general/reading', [HomeController::class, 'TestGeneralReading'])->name('start.general.reading');
    Route::get('/academic/writing/confirm_details', [HomeController::class, 'academicWritingConfirm'])->name('academic.writing.confirm_details');
    Route::get('/general/writing/confirm_details', [HomeController::class, 'generalWritingConfirm'])->name('general.writing.confirm_details');
    Route::get('/test/start/academic/writing', [HomeController::class, 'TestAcademicWriting'])->name('start.academic.writing');
    Route::get('/test/start/general/writing', [HomeController::class, 'TestGeneralWriting'])->name('start.general.writing');

    Route::get('/test/start/general', [HomeController::class, 'generalStartTest'])->name('general_start_test');
});

Route::get('/login/admin', [AdminLoginController::class, 'Login'])->name('admin_login_page')->middleware('AdminAlreadyLoggedIn');
Route::post('admin_login', [AdminLoginController::class, 'adminLogin']);

// Route::get('/', [StudentLoginController::class, 'Login'])->name('student_login_page')->middleware('StudentAlreadyLoggedIn');
Route::post('student_login', [StudentLoginController::class, 'studentLogin'])->name('student.login');
Route::get('/student/signup', [StudentManageController::class, 'StudentSignUp'])->name('student_signup')->middleware('StudentAlreadyLoggedIn');
Route::post('/register_student', [StudentManageController::class, 'RegisterStudent'])->name('register_student');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('optimize:clear');
    return "Cache is cleared";
});
