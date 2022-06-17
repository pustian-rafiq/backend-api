<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

     /**
      * Check validation for person informations
      * This method register a new person into the database
      * Route: api/auth/register
     */
    
     public function register(Request $request) {
         
        //Validate person data
        $validator = Validator::make($request->all(),[
            "firstName" => "required|string",
            "lastName" => "required|string",
            "email" => "required|email|unique:persons,email",
            "password" => "required|min:6"
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ],401);
        }

        try{

           $data = Person::create([
                "firstName" => $request->firstName,
                "lastName" => $request->lastName,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);

            return response()->json([
                "data" => $data
            ],201);

        }catch(Exception $err){
            return response()->json([
                "success" => false,
                "errors" => $err
            ],401);
        }
       
    }
}