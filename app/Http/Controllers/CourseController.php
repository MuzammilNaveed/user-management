<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Courses;
use App\Models\Lectures;

class CourseController extends Controller
{
    //

    public function index() {
        return view('admin.courses.course.course');
    }

    public function save(Request $request) {
        
        $course = new Courses();
        $course->title =  $request->title;
        $course->type = $request->type;
        $course->duration = $request->duration;

        if($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            
            $file = $request->file('thumbnail')->getClientOriginalName();
            $imageName = $file . '.' . pathinfo($file, PATHINFO_EXTENSION);

            $filesize = $image->getSize()/1024;
            if($filesize > 2048) {
                return response()->json([
                    'message' => 'File size exceeds 2MB',
                    'status' => 500,
                    'success' => true
                ]);
            }else{
                $image->move(public_path('course_img'), $imageName);
                $course->thumbnail = $imageName;
            }

        }
        $course->created_by = Auth::user()->id;
        $course->save();

        return response()->json([
            'message' => 'Course Added Successfully',
            'status' => 200,
            'success' => true
        ]);
    }

    public function view() {
        return Courses::all();
    }

    public function update(Request $request) {
        
        $course = Courses::find($request->id);
        $course->title =  $request->title;
        $course->type = $request->type;
        $course->duration = $request->duration;

        if($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            
            $file = $request->file('thumbnail')->getClientOriginalName();
            $imageName = $file . '.' . pathinfo($file, PATHINFO_EXTENSION);

            $filesize = $image->getSize()/1024;
            if($filesize > 2048) {
                return response()->json([
                    'message' => 'File size exceeds 2MB',
                    'status' => 500,
                    'success' => true
                ]);
            }else{
                $image->move(public_path('course_img'), $imageName);
                $course->thumbnail = $imageName;
            }

        }
        $course->created_by = Auth::user()->id;
        $course->save();

        return response()->json([
            'message' => 'Course Updated Successfully',
            'status' => 200,
            'success' => true
        ]);
    }





    // lectures


    public function lectures() {
        $courses = Courses::all();
        return view('admin.courses.lectures.lecture',compact('courses'));
    }

    public function saveLecture(Request $request) {
        $lecture = new Lectures();
        $lecture->title =  $request->title;
        $lecture->video_url = $request->video_url;
        $lecture->course_id = $request->course_id;
        $lecture->description = $request->description;
        $lecture->instructor = $request->instructor;

        $lecture->created_by = Auth::user()->id;
        $lecture->save();

        return response()->json([
            'message' => 'Lecture Added Successfully',
            'status' => 200,
            'success' => true
        ]);
    }

    public function viewLecture() {
        return Lectures::all();
    }


    public function updateLecture(Request $request) {
        
        $lecture = Lectures::find($request->id);
        $lecture->title =  $request->title;
        $lecture->video_url = $request->video_url;
        $lecture->course_id = $request->course_id;
        $lecture->description = $request->description;
        $lecture->instructor = $request->instructor;

        $lecture->created_by = Auth::user()->id;
        $lecture->save();

        return response()->json([
            'message' => 'Lecture Updated Successfully',
            'status' => 200,
            'success' => true
        ]);
    }


}
