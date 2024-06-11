<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserEditRequest;
class UserController extends Controller
{
    //

    protected $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function index(){
        return $this->userRepository->getAllUser();
    }

    public function show($id){
        $user = $this->userRepository->getUserById($id);
        return $user;
    }

    public function store(UserCreateRequest $request){
        $validated = $request->validated();

        $user = $this->userRepository->create($validated);
        return response()->json([
            "success" => true,
            "message" => "User Stored",
            "data" => $user,
        ]);
    }

    public function update($id, Request $request)
    {
        return $this->userRepository->updateUser($request,$id);
    }

    public function destroy($id){
        return $this->userRepository->delete($id);
    }

    public function getByCondition(Request $request){
        return $this->userRepository->getByCondition($request);
    }
    public function restore($id){
        return $this->userRepository->restoreUser($id);
    }
}
