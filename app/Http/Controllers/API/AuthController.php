<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
// use Auth;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    // registration API
     
      public function register(Request $request){

        $validator = Validator::make($request->all(), [
      
            'name' => 'required',
            'email'=> 'required|unique:users,email',
            'password'=> 'required|min:8|confirmed',
            'password_confirmation'=> 'required|min:8'

        ]);

           if($validator->fails()) {
            return response()->json( [
        'status' => 'fail',
        'message' => $validator->errors()
            ], 400);

        }

        $data = $request->all();


        // Image Upload
        $imagePath = null;
        if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
           
            $file = $request->file('profile_picture');

            // Geerate a unique filename
            $fileName = time() . '_' . $file->getClientOriginalName();
           
            // Move file to the public directory
            $file->move(public_path('storage/profile'), $fileName);

            // Save the relative path to the database
            $imagePath = "storage/profile/".$fileName;
        } 

        $data['profile_picture'] = $imagePath;

        //  $data['password'] = Hash::make($request->password);
        User::create($data);   // Users table new record will be created

        return response()->json( [
            'status'=> 'success',
            'message'=> 'New User Creater Successfully'
            ] , 201);
}



  //    LOGIN API

        public function login(Request $request){
    
            $validator = Validator::make($request->all(), [
        
                'email'=> 'required',
                'password'=> 'required'
    
            ]);
    
             if($validator->fails()) {
                return response()->json( [
            'status' => 'fail',
            'message' => $validator->errors()
                ], 400);
    
            }
    
           // $credentials = request(['email', 'password']);
     
            if(Auth::attempt(['email'=> $request->email, 'password'=> $request->password]))
            {
                $user = Auth::user();
                
            //   $response = [
            //     'token' => $user->createToken('BlogApp')->plainTextToken,
            //     'email' => $user->email,
            //     'name'  => $user->name
            // ];

        
              $response['token'] = $user->createToken('BlogApp')->plainTextToken;
               $response['email'] = $user->email;
                $response['name'] = $user->name;
        
                return response()->json( [
                    'status'=> 'success',
                    'message'=> 'User Login Successfully',
                    'data'=> $response
                    ] , 200);
            }
            else
            {
                return response()->json( [
                    'status'=> 'fail',
                    'message'=> 'Invalid Credentials'
                    ] , 400);
            }
       
            }

            // PROFILE API  
          
            public function profile(): JsonResponse {
                $user = Auth::user();

                return response()->json( [
                    'status'=> 'success',
                    'message'=> 'User Profile Data',
                    'data'=> $user
                    ] , 200);
            }


            //  LOGOUT API


            // public function logout() {
            //     $user = Auth::user();
            //     $user->tokens()->delete();

            //     return response()->json( [
            //         'status'=> 'success',
            //         'message'=> 'User Logout Successfully'
            //         ] , 200);
            // }
                     
    // }
     
            //======================= Isme ye upar wala sahi h but phir bhi ye error aa rh ah  ========================
     
public function logout(Request $request)
{
    //  Delete the token for the currently authenticated user
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'status'  => 'success',
        'message' => 'User Logout Successfully'
    ], 200);

}

}
 