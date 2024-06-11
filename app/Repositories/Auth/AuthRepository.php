<?php

namespace App\Repositories\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


//use Your Model

/**
 * Class AuthRepository.
 */
class AuthRepository
{
    /**
     * @return string
     *  Return the model
     */

    public function model()
    {
        //return YourModel::class;
    }

    public function register(Request $request){

        $fields = $request->validate([
            "first_name" => "required|max:128",
            "last_name" => 'required|max:128',
            "date_of_birth" => 'required|date_format:"Y-m-d"|before:-18 years',
            "gender" => "required",
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'full_name' => $fields['last_name']  . " " . $fields['first_name'],
            'date_of_birth' => $fields['date_of_birth'],
            'gender' => $fields['gender'],
            'email' => $fields['email'],
            'password' => $fields['password']
        ]);
        $response = [
            [
                'message'=> "User successfully created"
            ],
            [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'full_name' => $user->full_name,
                'date_of_birth' => $user->date_of_birth,
                'gender' => $user->gender,
                'email' => $user->email,
                'password' => $user->password,
                'id'=>$user->id,
                'created_at'=>$user->created_at,
                'updated_at'=>$user->updated_at,
            ]
        ];
        return response($response, 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=> 'required|email',
            'password'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'error'=> $validator->errors()
            ],422);
        }
        $user = User::where('email',$request->email)->first();
        if($user){
            if(Hash::check($request->password,$user->password))
            {
                $token = $user->createToken('DuAnCNTT2LaravelReactJs')->plainTextToken;
                return response()->json([
                    'message'=>'Login Successfully',
                    'token'=>$token,
                    'data'=>$user

                ],200);
            }
            else{
                return response()->json([
                    'message'=>'Incorrect credentials'

                ],400);
            }
        }
        else{
            return response()->json([
                'message'=>'Incorrect credentials'

            ],400);
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User log out successfully'
        ]);
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'password'=>'required|min:6|max:100',
            'confirm_password'=>'required|same:password'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validator fails',
                'errors'=>$validator->errors()
            ],422);
        }
        $user = $request->user();
        if(Hash::check($request->old_password,$user->password)){
            $user->update([
                'password' => Hash::make($request->password)

            ]);
            return response()->json([
                'message'=>'Password successfully updated'
            ]);
        }
        else{
            return response()->json([
                'message'=>"Old password dose not match"
            ],400);
        }
    }
}
