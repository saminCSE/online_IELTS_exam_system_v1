<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentManageController extends Controller
{
    public function manageCandidate()
    {
        $items = Student::orderByDesc('id')->get();
        return view('admin.student_manage.index', compact('items'));
    }

    public function addCandidateNumber()
    {

        return view('admin.student_manage.create');
    }

    public function candidateStore(Request $request)
    {

        $identityNo = $request->input('identity_no');


        $prefix = 'CDMOCK';

        // Generate a random candidate_id
        $candidateNumber = $prefix . rand(100000, 999999);

        while (Student::where('candidate_id', $candidateNumber)->exists()) {
            $candidateNumber = $prefix . rand(100000, 999999);
        }

        $student = new Student();
        $student->identity_no = $identityNo;
        $student->candidate_id = $candidateNumber;

        $student->save();
        return redirect()->route('candidate_list');
    }
    public function candidateStatusUpdate(Request $request)
    {
        $stat = Student::find($request->id);
        $stat->status = $request->status;
        $stat->update();
        return response()->json(['success' => 'Status change successfully.']);
    }

    public function StudentSignUp()
    {
        return view('student.student_signup');
    }

    public function RegisterStudent(Request $request)
    {

        // dd($request->all());
        $student = Student::where('identity_no', $request->identity_no)
            ->where('candidate_id', $request->candidate_id)
            ->first();

        if (!$student) {
            return redirect()->back()->with('message', 'Invalid NID/Passport No or Candidate No');
        }

        if ($student->name || $student->email) {
            return redirect()->back()->with('message', 'You have already taken this exam');
        }

        // If no duplicates are found, create a new student
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;

        // dd($student);
        $student->save();

        Auth::guard('student')->login($student);

        return redirect()->route('studentDashboard')->with('success', 'Registered successfully. Please log in!');
    }
}
