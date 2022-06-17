<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

     /**
      * Check validation for login request informations
      * This method loggedin an existing user
      * Generate a jwt token for protection the other routes
      * Route: api/auth/login
     */

    public function login(Request $request)
    {
         $validator = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required|min:6"
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ],401);
        }

        
        try{
            $credentials = $request->only('email', 'password');

            if ($token = $this->guard()->attempt($credentials)) {
                return $this->respondWithToken( $credentials, $token);
            }
    
            return response()->json(['error' => 'Unauthorized'], 401);

        }catch(Exception $error){
                return response()->json([
                "success" => false,
                "errors" => $error
            ],401);
        }
       
    }


      /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken( $credentials, $token)
    {
        return response()->json([
            'access_token' => $token,
            "person" =>  $credentials

        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}