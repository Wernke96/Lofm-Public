<?php


namespace Tests\Unit\Lofm\Domain\Service;


use App\Lofm\Domain\Models\User;
use App\Lofm\Domain\Services\UserService;
use App\Lofm\Exceptions\UnauthorizedExecption;
use App\Lofm\Infrastructure\Jenssegers\Repository\UserRepository;

class UserServiceTest extends \Tests\Unit\TestCase
{
    private $lofmUserRepository;
    private $userService;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->lofmUserRepository = $this->createMock(UserRepository::class);
        $this->userService = new UserService($this->lofmUserRepository);
    }

    public function testGetUserById() :void
    {
        $userModel = $this->mockUserModel([
                "id" => "1234"
            ]);
        $this->lofmUserRepository->expects($this->once())
            ->method("findById")
            ->with($userModel->getId())
            ->willReturn($userModel);

        $this->assertInstanceOf(User::class,$this->lofmUserRepository->findById("1234"));
    }

    public function testMakeUser() :void
    {
        $testUser = "testUser";
        $testEmail = "testUser@example.com";
        $testPassword = "TestPassword!7667";
        $this->lofmUserRepository
            ->expects($this->once())
            ->method("findByEmail")
            ->willReturn(null);

        $this->lofmUserRepository
                ->expects($this->once())
                ->method("create");
        $this->assertSame("The User with the email {$testEmail} and userName {$testUser} has been created",$this->userService->makeUser($testUser,$testEmail,$testPassword));
    }

    public function testMakeUserExpection()
    {

        $testUser = "testUser";
        $testEmail = "testUser@example.com";
        $testPassword = "TestPassword!7667";
        $this->lofmUserRepository
            ->expects($this->once())
            ->method("findByEmail")
            ->willReturn($this->mockUserModel([
                "userName" => $testUser,
                "email" => $testEmail,
                "password" => $testPassword
            ]));
        $this->expectException(UnauthorizedExecption::class);
        $this->userService->makeUser($testUser,$testEmail,$testPassword);
    }
}
