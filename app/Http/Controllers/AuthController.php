<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Auth\AuthRepository;

class AuthController extends Controller
{
    //
    protected $authRepository;
    public function __construct(AuthRepository $authRepository){
        $this->authRepository = $authRepository;
    }

    public function login(Request $request)
    {
      $user = $this->authRepository->login($request);
      return $user;
    }

    public function register(Request $request) {
        $user = $this->authRepository->register($request);
        return $user;
    }
    public function logout(Request $request)
    {
       $user = $this->authRepository->logout($request);
       return $user;
    }

    public function userProfile(Request $request)
    {
        return $request->user();
    }

    public function change_password(Request $request){
        $changePassword = $this->authRepository->changePassword($request);
        return $changePassword;
    }





}
