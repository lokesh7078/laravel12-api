<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;


class StudentApiController extends Controller
{
  
    public function index()
    {
        $students = Student::get();

        return response()->json([
            "status" => "success",
            "data" => $students
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:students,email',
            'gender' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "fail",
                'message' => $validator->errors()

                ],  400);
    }

        $data = $request->all();
        
        Student::create($data); // it will store data into database table 'students'

        return response()->json([
            "status" => "success",
            "message" => "Student created successfully"
        ], 201);

}

    public function show(string $id)
    {
        $student = Student::find($id);

        if ($student) {
            return response()->json([
                "status" => "success",
                "data" => $student
            ],200);
    }

         return response()->json([
            "status" => "fail",
            "message" => "No User Found"
         ], 404);

    }


    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|unique:students,email,'.$id,
            'gender' => 'required',
        ]);


        if ($validator->fails()) {
         return response()->json([
            'status'=> 'fail',
            'message'=> $validator->errors()
            ], 400);
         
        }

        $student = Student::find($id);

        if(!$student) {
            return response()->json([
                "status" => "fail",
               " message" => "No Student Found"
            ], 400);
        }

          $student->name = $request->name;
            $student->email = $request->email;
            $student->gender = $request->gender;
            $student->save();   // it will update data into database table 'students'
   
   
        return response()->json([
            "status"=> "success",
            "message" => "Student updated successfully",
            "data"=> $student
        ], 200);

    
        }

    public function destroy(string $id)
    {
        // find the student whether exist or not 
        $student = Student::find($id);
        if(!$student) {
           return response()->json([
            "status" => "fail",
            "message" => "Student not found"
           ],404);
        }

        $student->delete();  // delete the student from database

        return response()->json( [
            "status" => "success",
            "message" => "Student deleted successfully"
        ], 201);
    }
}









// namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// class StudentApiController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         $students = Student::get();

//         return response()->json(data: [
//             "status" => "success",
//             "data" => $students
//         ], 200);
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
        
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(string $id)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//     }
// } 
