<?php


namespace Tests\Unit\Lofm\Infrastructure\Repository;


use App\Lofm\Exceptions\UnauthorizedExecption;
use App\Lofm\Exceptions\UserErrorException;
use App\Lofm\Infrastructure\Jenssegers\Repository\UserRepository;
use App\User;
use Faker\Factory;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Psr\Log\LoggerInterface;
use Tests\TestCase;
use Tests\Unit\MockModels;


class UserRepositoryTest extends TestCase
{
    use MockModels;

    /**
     * @var User
     */
    private $user;

    private $lofmUserRepository;

    private $hasher;

    private $logger;
    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->user = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->addMethods(
                [
                    'create',
                    'get',
                    "byEmail",
                    "first",
                    "findOrFail"
                ]
            )
            ->getMock();
        $this->hasher = $this->getMockBuilder(Hasher::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                "make",
                "info",
                "check",
                "needsRehash"
                ])->getMock();
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->lofmUserRepository = new UserRepository(
            $this->user,
            $this->hasher,
            $this->logger
        );
    }

    public function testCreate() :void
    {
        $userValueObject = $this->mockUserValueObject(
            [
                "email" => "test@example.com",
                "userName" => "test",
                "password" => "password!123"
            ]
        );
        $this->hasher
            ->method("make")
            ->willReturn("password!123");

        $this->user
            ->expects($this->once())
            ->method('create');
        $this->lofmUserRepository->create($userValueObject);

        $this->assertTrue(True);
    }

    public function testFindByEmailReturnNull(): void
    {
        $this->user
            ->method("byEmail")
            ->willReturnSelf();

        $this->user
            ->method("get")
            ->willReturn($this->mockEloquentUsers(0,[]));

       $this->assertEquals(null,$this->lofmUserRepository->findByEmail("testUser"));

    }

    public function testReturnEmailReturnUserCollection() :void
    {
        $this->user
            ->method("byEmail")
            ->willReturnSelf();

        $this->user
            ->method("get")
            ->willReturn($this->mockEloquentUsers(1,[[
                "email" => "testUser@example.com",
                "name" => ""
            ]]));
        $testCase = $this->lofmUserRepository->findByEmail("testUser");
        Carbon::getTestNow();
        Carbon::getTestNow();
        $this->assertInstanceOf(\App\Lofm\Domain\Models\User::class,$this->lofmUserRepository->findByEmail("testUser"));

    }

    public function testUserFindIdExpectation() :void
    {

        $this->user
            ->method("findOrFail")
            ->willThrowException(new ModelNotFoundException());

        $this->logger
            ->expects($this->once())
            ->method("info");
        $this->expectException(UserErrorException::class);
        $this->lofmUserRepository->findById("608f1cd04d7bae279a4ca733");
    }



}
