<?php


namespace Tests\Unit\Lofm\Domain\Models;


use Carbon\Carbon;

class UserModelTest extends \Tests\Unit\TestCase
{
    public function testUserModel() :void
    {
        /**
         * User constructor.
         * @param string $id
         * @param string $email
         * @param string $password
         * @param string|null $email_verified_at
         * @param string $userName
         * @param Carbon $created_at
         * @param Carbon $updated_at
         */
        $created_at = Carbon::create(2021,04,10);
        $updated_at = Carbon::create(2021,04,10);
        $userModel = $this->mockUserModel([
            "id" => "507f191e810c19729de860ea",
            "email" => "test@example.com",
            "password" => "password123",
            "email_verified_at" => null,
            "userName" => "testUser",
            "created_at" => $created_at,
            "updated_at" => $updated_at
        ]);

        $this->assertSame(
            [
                "id" => "507f191e810c19729de860ea",
                "email" => "test@example.com",
                "email_verified_at" => null,
                "userName" => "testUser",
                "password" => "password123",
                "created_at" => $created_at,
                "updated_at" => $updated_at
            ],
        $userModel->toArray());
    }

}
