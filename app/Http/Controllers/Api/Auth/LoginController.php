<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Lofm\Domain\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function login(Request $request)
    {
        $cred = $request->only('email', 'password');
        if(!$token = auth()->attempt($cred)){
            return response()->json(['error'=>'Incorrect email/password'],Response::HTTP_FORBIDDEN);
        }
        return response()->json(['token'=> $token ],Response::HTTP_OK);

    }
    public function createUser(Request $request)
    {
        $userInfo = $request->json()->all();
        $message = $this->userService->makeUser($userInfo["username"], $userInfo["email"], $userInfo["password"]);
            return response()->json(["message"=> $message ], Response::HTTP_CREATED);
    }
}
