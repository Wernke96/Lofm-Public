<?php

namespace App\Http\Controllers\Api;
use App\Lofm\Domain\Services\UserService;
use App\Lofm\Infrastructure\Jenssegers\Repository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use App\Http\Controllers\Controller;
use Psr\Log\LoggerInterface;

class UserController extends Controller
{
    private UserService $userService;
    private UserRepository $userRepository;
    private LoggerInterface $logger;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param UserRepository $userRepository
     */
    public function __construct(UserService $userService, UserRepository $userRepository, LoggerInterface $logger)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    public function getUserInfo()
    {
        $user = JWTAuth::parseToken()->user();
        $info = array("username"=> $user->name,'email'=>$user->email, "id" => $user->getId() );
        return response()->json($info);
    }

    public function userProfile(string $userId)
    {
        $userModel = $this->userRepository->findById($userId);
        return response()->json([
                "id" => $userModel->getId(),
                "username" => $userModel->getUserName(),
                "email" => $userModel->getEmail(),
                "created_at" => $userModel->getCreatedAt()->format('m/d/y')
            ],Response::HTTP_OK);

    }

    public function deleteUser(string $userId)
    {
        $this->userService->deleteByUserId($userId);
        return response()->json(["success" => "user Been Deleted"],Response::HTTP_OK);
    }



}
