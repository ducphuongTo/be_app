<?php

namespace App\Repositories\User;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Your Model

/**
 * Class UserRepository.
 */
class UserRepository
{
    /**
     * @return string
     *  Return the model
     */



    public function getAllUser(){
        return response()->json(User::all());
    }
    public function getUserById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user not found.'
            ], 400);
        }
        return $user;
    }

    public function getByCondition(Request $request){
        $size = $request->query("size");
        $result = User::select("users.*")
            ->filter($request)
            ->sort($request)
            ->search($request)
            ->paginate($size);
        return $result;
    }

    public function checkIfUserIsAdmin()
    {
        $isAdmin = DB::table("users")
            ->where("id", auth()->id())
            ->value("is_admin");
        if ($isAdmin == true) {
            return true;
        }
        return false;
    }

    public function create($request){
        if($this->checkIfUserIsAdmin()){
            $request['full_name']="";
            $user = User::create($request);
            $newUser = User::find($user["id"]);
            return response()->json([
               "message" => "User create successfully",
               "data" => $newUser
            ],200);
        }
        else{
            return response()->json([
                "message" => "You are not the admin",

            ],403);
        }
    }
    public function updateUser(Request $request, $id)
    {
        if($this->checkIfUserIsAdmin())
        {
            $user = User::find($id);
            if (is_null($user)) {
                return response()->json(['message' => 'User Not Found'], 404);
            }
            $user->update($request->all());
            return response()->json([
                "message" => "User update successfully",
                "data" => $user
            ],200);
        }
        else{
            return response()->json([
                "message" => "You are not the admin",
            ],403);
        }

    }
    public function delete($id)
    {
        if($this->checkIfUserIsAdmin()){
            $user = User::find($id);
            if (is_null($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User dose not exist'
                ]);
            }
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User are inactive'
            ], Response::HTTP_OK);
        }
        else{
            return response()->json([
                "message" => "You are not the admin",
            ],403);
        }
    }

    public function restoreUser($id){
        $user = User::withTrashed()->where("id",$id)->restore();
        return response()->json([
            "message" => "Product are active",
        ]);
    }
}
