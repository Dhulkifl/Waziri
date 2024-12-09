<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teachers;
use App\Models\Courses;

class TeachersController extends Controller
{
    function teachers()
    {
        $teachers = Teachers::all();
        $count = 1;
        return view('contents.teachers.teachers', compact('teachers', 'count'));
    }

    //save Teachers
    function saveTeacher(Request $request)
    {
        //dd($request->all());
        $teacher_save_type = $request->input('teacher_save_type');
        $teacher_id = $request->input('teacher_id');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $father_name = $request->input('father_name');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $status = $request->input('status');
        $contract_start_date = $request->input('contract_start_date');
        $contract_end_date = $request->input('contract_end_date');
        $photo = $request->file('photo');

        $imageName = "";
        //check if the image exist
        if ($request->hasfile('photo')) {
            //set the image name
            $imageName = time() . '.' . $photo->getClientOriginalName();
            // move the image to a specific folder 
            $photo->move('uploads/images/teachers', $imageName);
            // assign the value to the variable for image name in Model/Database
        }

        if ($teacher_id != "null" && $teacher_save_type != "new") {

            $teacher = Teachers::where('id', $teacher_id)->first();
            $teacher->first_name = $first_name;
            $teacher->last_name = $last_name;
            $teacher->father_name = $father_name;
            $teacher->address = $address;
            $teacher->phone = $phone;
            $teacher->status = $status;
            $teacher->contract_start_date = $contract_start_date;
            $teacher->contract_end_date = $contract_end_date;
            if ($imageName != "") {
                $teacher->photo = $imageName;
            }
            $teacher->save();

            return redirect()->route('teacherDetails', $teacher_id);
        } else {
            $teacher = new Teachers;
            $teacher->first_name = $first_name;
            $teacher->last_name = $last_name;
            $teacher->father_name = $father_name;
            $teacher->address = $address;
            $teacher->phone = $phone;
            $teacher->status = $status;
            $teacher->contract_start_date = $contract_start_date;
            $teacher->contract_end_date = $contract_end_date;
            $teacher->photo = $imageName;
            $teacher->save();

            return redirect()->route('teachers');
        }
    }

    public function teacherDetails($teacher_id)
    {
        $teacher = Teachers::where('id', $teacher_id)->first();
        $courses = Courses::where('teacher_id', $teacher_id)->get();

        return view('contents.teachers.teacherDetails', compact('teacher', 'courses'));
    }

}
