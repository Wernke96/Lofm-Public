<?php


namespace App\Lofm\Domain\Services;


use App\Lofm\Domain\Models\User;
use App\Lofm\Domain\Repositories\LofmUserRepository;
use App\Lofm\Exceptions\UnauthorizedExecption;

use Psr\Log\LoggerInterface;
use App\Lofm\Domain\ValueObjects\User as UserValueObject;

class UserService
{

    private LofmUserRepository $userRepository;

    /**
     * UserService constructor.
     * @param LofmUserRepository $userRepository
     */
    public function __construct(
        LofmUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;

    }

    public function makeUser(string $userName, string $email, string $password) :string
    {
        $user = new UserValueObject(
            $email,
            $userName,
            $password
        );
        $uppercase = preg_match('@[A-Z]@',$password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        if (!$uppercase || !$lowercase || !$number ) {
            throw new UnauthorizedExecption("invalid Password");
        }

        if(!is_null($this->userRepository->findByEmail($user->getEmail())))
        {
            throw new UnauthorizedExecption("email already in use");
        }

        $this->userRepository->create($user);
        return "The User with the email {$email} and userName {$userName} has been created";
    }

    public function getUserById(string $id): User
    {
        return $this->userRepository->findById($id);
    }

    public function deleteByUserId(string $id) :void
    {
        $this->userRepository->delete($id);
    }

}
