<?php


namespace Tests\Unit\Lofm\Domain\ValueObjects;


class UserValueObjectTest extends \Tests\Unit\TestCase
{
    public function testToArray()
    {
        $userValueObject = $this->mockUserValueObject([
            "email" => "test@example.com",
            "userName" => "testUser",
            "password" => "password123"
        ]);
        $this->assertSame([
            "email" => "test@example.com",
            "userName" => "testUser",
            "password" => "password123"
            ], $userValueObject->toArray()
        );
    }


}
