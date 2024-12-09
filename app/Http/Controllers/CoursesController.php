<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subjects;
use App\Models\Teachers;
use App\Models\Courses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoursesController extends Controller
{
    function courses()
    {
        $courses = Courses::all();
        $subjects = Subjects::all();
        $teachers = Teachers::all();
        $count = 1;
        return view('contents.courses.courses', compact('courses', 'subjects', 'teachers', 'count'));
    }

    //save Courses
    function saveCourse(Request $request)
    {
        //dd($request->all());
        $course_save_type = $request->input('course_save_type');
        $course_id = $request->input('course_id');
        $course_name = $request->input('course_name');
        $subject_id = $request->input('subject_id');
        $teacher_id = $request->input('teacher_id');
        $time = $request->input('time');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $fee = $request->input('fee');
        $created_by = Auth::id();

        if ($course_id != "null" && $course_save_type != "new") {

            $course = Courses::where('id', $course_id)->first();
            $course->course_name = $course_name;
            $course->subject_id = $subject_id;
            $course->teacher_id = $teacher_id;
            $course->time = $time;
            $course->start_date = $start_date;
            $course->end_date = $end_date;
            $course->fee = $fee;
            $course->save();

            return redirect()->route('courseDetails', $course_id);
        } else {
            $course = new Courses;
            $course->course_name = $course_name;
            $course->subject_id = $subject_id;
            $course->teacher_id = $teacher_id;
            $course->time = $time;
            $course->start_date = $start_date;
            $course->end_date = $end_date;
            $course->fee = $fee;
            $course->created_by = $created_by;
            $course->save();

            return redirect()->route('courses');
        }
    }

    public function courseDetails($course_id)
    {
        $course = Courses::where('id', $course_id)->first();
        $subjects = Subjects::all();
        $teachers = Teachers::all();

        return view('contents.courses.courseDetails', compact('course', 'subjects', 'teachers'));
    }
}
