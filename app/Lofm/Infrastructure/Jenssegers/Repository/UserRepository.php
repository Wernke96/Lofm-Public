<?php


namespace App\Lofm\Infrastructure\Jenssegers\Repository;


use App\Lofm\Domain\Repositories\LofmUserRepository;
use App\Lofm\Exceptions\UserErrorException;
use App\User;
use App\Lofm\Domain\Models\User as UserModel;
use App\Lofm\Domain\ValueObjects\User as UserValueObject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Psr\Log\LoggerInterface;

class UserRepository implements LofmUserRepository
{
    /**
     * @var User
     */
    private User $userModel;

    private \Illuminate\Contracts\Hashing\Hasher $hasher;

    private LoggerInterface $logger;

    /**
     * UserRepository constructor.
     * @param User $userModel
     * @param \Illuminate\Contracts\Hashing\Hasher $hasher
     * @param LoggerInterface $logger
     */
    public function __construct(
        User $userModel,
        \Illuminate\Contracts\Hashing\Hasher $hasher,
        LoggerInterface $logger

    )
    {
        $this->userModel = $userModel;
        $this->hasher = $hasher;
        $this->logger = $logger;
    }

    public function create(UserValueObject $user): void
    {
        $this->userModel
            ->create([
                'email' => $user->getEmail(),
                'name' => $user->getUserName(),
                'password' => $this->hashPassword($user->getPassword())
            ]);
    }

    public function findByEmail(string $email): ?UserModel
    {
        $eloquentUser = $this->userModel
            ->byEmail($email)
            ->get();
        /** @var User $eloquentUser */
        if ($eloquentUser->count() != 0)
        {
            return $this->constructUserModel($eloquentUser->first());
        }

        return null;


    }

    public function findById(string $id): UserModel
    {
        try {
            $user = $this->userModel->findOrFail($id);
            return $this->constructUserModel($user);
            } catch (\Exception $exception) {
                $this->logger->info("error when trying to find this user",[
                    "message" => $exception->getMessage(),
                    "file" => $exception->getFile()
                ]);
                throw new UserErrorException("User not Found");
        }
    }

    private function constructUserModel(User $user)
    {

        return new UserModel(
            $user->getId(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getEmailVerifiedAt(),
            $user->getName(),
            Carbon::parse($user->getCreatedAt()),
            Carbon::parse($user->getUpdatedAt())
        );
    }

    private function hashPassword(string $password) :string
    {
        return $this->hasher->make($password);
    }

    public function delete(string $id): void
    {
        $this->userModel->query()->find($id)->delete();
    }

    public function forceDelete():void
    {
        $users = $this->userModel->onlyTrashed()->get();
        $this->logger->info(print_r($users->toArray(),true));
        foreach($users as $user) {
            $user->forceDelete();
        }
    }
}
