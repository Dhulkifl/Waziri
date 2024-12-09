<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Students;
use App\Models\Courses;
use App\Models\CourseStudents;
use App\Models\Fees;
use App\Models\FeesItems;



class StudentsController extends Controller
{
    public function studentsPage()
    {
        $students = Students::all();
        $courses = Courses::all();
        $count = 1;
        return view('contents.students.students', compact('students', 'count', 'courses'));
    }

    function newStudent(Request $request)
    {

        //dd($request->all());
        DB::beginTransaction();

        try {
            $student_save_type = $request->input('student_save_type');
            $student_id = $request->input('student_id');
            $name = $request->input('name');
            $father_name = $request->input('father_name');
            $last_name = $request->input('last_name');
            $phone = $request->input('phone');
            $address = $request->input('address');
            $status = $request->input('status');
            $photo = $request->file('photo');

            $imageName = "";
            //check if the image exist
            if ($request->hasfile('photo')) {
                //set the image name
                $imageName = time() . '.' . $photo->getClientOriginalName();
                // move the image to a specific folder 
                $photo->move('uploads/images/students', $imageName);
                // assign the value to the variable for image name in Model/Database
            }

            if ($student_id != "null" && $student_save_type != "new") {

                $student = Students::where('id', $student_id)->first();
                $student->name = $name;
                $student->father_name = $father_name;
                $student->last_name = $last_name;
                $student->phone = $phone;
                $student->address = $address;
                $student->status = $status;
                if ($imageName != "") {
                    $student->photo = $imageName;
                }
                $student->save();

            } else {
                $student = new Students;
                $student->name = $name;
                $student->father_name = $father_name;
                $student->last_name = $last_name;
                $student->phone = $phone;
                $student->address = $address;
                $student->status = $status;
                if ($imageName != "") {
                    $student->photo = $imageName;
                }
                $student->save();

                // enroll the student into the course
                $this->enrollStudent($request, $student->id);
            }

            DB::commit();

            if ($student_id != "null" && $student_save_type != "new") {
                return redirect()->route('studentDetails', $student_id);
            } else {
                return redirect()->route('students');
            }
        } catch (\Exception $e) {
            DB::rollback();
            // handle the exception
            return redirect()->back()->withErrors(['error' => 'An error occurred while saving the student.']);
        }
    }

    function enrollStudent(Request $request, $studentId)
    {
        $course_id = $request->input('course_id');
        $student_id = $studentId;
        $enrollment_date = $request->input('enrollment_date');
        $tuition_fee = $request->input('tuition_fee');
        $book_fee = $request->input('book_fee');
        $discount = $request->input('discount');
        $paid = $request->input('paid');
        $month = $request->input('month');
        $year = $request->input('year');

        // Check if course student already exists
        $courseStudent = CourseStudents::where('course_id', $course_id)->where('student_id', $student_id)->first();
        if (!$courseStudent) {
            $courseStudent = new CourseStudents;
            $courseStudent->course_id = $course_id;
            $courseStudent->student_id = $student_id;
            $courseStudent->enrollment_date = $enrollment_date;
            $courseStudent->save();

            // Insert into fees table
            $fee = new Fees;
            $fee->course_id = $course_id;
            $fee->student_id = $student_id;
            $fee->save();

            // Insert into fees_items table for tuition fee
            $feeItem1 = new FeesItems;
            $feeItem1->fee_id = $fee->id;
            $feeItem1->fee_type = 'tuition';
            $feeItem1->fee_amount = $tuition_fee;
            $feeItem1->discount = $discount;
            $feeItem1->paid = $paid;
            $feeItem1->month = $month;
            $feeItem1->year = $year;
            $feeItem1->payment_date = $enrollment_date;
            $feeItem1->save();

            // Insert into fees_items table for book fee
            $feeItem2 = new FeesItems;
            $feeItem2->fee_id = $fee->id;
            $feeItem2->fee_type = 'book';
            $feeItem2->fee_amount = $book_fee;
            $feeItem2->discount = 0;
            $feeItem2->paid = $book_fee;
            $feeItem2->month = $month;
            $feeItem2->year = $year;
            $feeItem2->payment_date = $enrollment_date;
            $feeItem2->save();

        }
    }

    function studentDetails($id)
    {
        $student = Students::where('id', $id)->first();
        $enrolledCourses = CourseStudents::where('student_id', $id)
            ->join('courses', 'course_students.course_id', '=', 'courses.id')
            ->select('courses.id', 'courses.course_name', 'courses.time', 'courses.start_date', 'courses.end_date', 'courses.fee', 'course_students.enrollment_date')
            ->get();

        $fees = FeesItems::where('student_id', $id)
            ->join('fees', 'fees_items.fee_id', '=', 'fees.id')
            ->select('fees.course_id', 'fees_items.fee_type', 'fees_items.fee_amount', 'fees_items.discount', 'fees_items.paid', 'fees_items.month', 'fees_items.year', 'fees_items.payment_date')
            ->get();

        return view('contents.students.studentDetails', compact('student', 'enrolledCourses', 'fees'));
    }

    public function getCourseDetails(Request $request)
    {
        $courseId = $request->input('course_id');
        $course = Courses::find($courseId);
        return response()->json([
            'time' => $course->time,
            'start_date' => $course->start_date,
            'end_date' => $course->end_date,
            'fee' => $course->fee,
        ]);
    }
}
