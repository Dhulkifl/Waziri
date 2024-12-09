<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Subjects;

class SubjectsController extends Controller
{
    // Controller function to view categories
    public function categories()
    {
        $categories = Categories::all();
        $count = 1;
        return view('contents.courses.categories', compact('categories', 'count'));
    }

    // Controller function to save categories
    function saveCategories(Request $request)
    {
        $category_id = $request->input('category_id');
        $category_name = $request->input('category_name');
        $save_type = $request->input('save_type');

        if ($save_type == 'new') {
            $category_exist = Categories::where('category_name', $category_name)->first();

            if (!$category_exist) {
                //insert into database
                $new_category = new Categories;
                $new_category->category_name = $category_name;
                $new_category->save();
            }
        } elseif ($save_type == 'update') {
            //uptade the details
            $category = Categories::where('id', $category_id)->first();
            $category->category_name = $category_name;
            $category->save();
        }
        $categories = Categories::all();
        return response()->json([
            'categories' => $categories
        ]);
    }
    public function subjects()
    {
        $subjects = Subjects::all();
        $categories = Categories::all();
        $count = 1;
        return view('contents.courses.subjects', compact('subjects', 'categories', 'count'));
    }

    // Controller function to save subjects
    function saveSubjects(Request $request)
    {
        $subject_id = $request->input('subject_id');
        $subject_name = $request->input('subject_name');
        $category_id = $request->input('category_id');
        $save_type = $request->input('save_type');

        if ($save_type == 'new') {
            $subject_exist = Subjects::where('subject_name', $subject_name)->first();

            if (!$subject_exist) {
                //insert into database
                $new_subject = new Subjects;
                $new_subject->subject_name = $subject_name;
                $new_subject->category_id = $category_id;
                $new_subject->save();
            }
        } elseif ($save_type == 'update') {
            //uptade the details
            $subject = Subjects::where('id', $subject_id)->first();
            $subject->subject_name = $subject_name;
            $subject->category_id = $category_id;
            $subject->save();
        }
        $subjects = Subjects::with('category')->get();
        return response()->json([
            'subjects' => $subjects
        ]);
    }

    // Controller function to get category id from category name
    function getCategoryId(Request $request)
    {
        $category_name = $request->input('category_name');
        $category = Categories::where('category_name', $category_name)->first();

        return response()->json([
            'category_id' => $category->id
        ]);
    }
}
