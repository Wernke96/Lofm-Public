<?php


namespace App\Lofm\Domain\Repositories;


use App\Lofm\Domain\Models\User;
use App\Lofm\Domain\ValueObjects\User as UserValueObject;

interface LofmUserRepository
{
    public function create(UserValueObject $user) :void;
    public function findByEmail(string $email) : ?User;
    public function findById(string $id) :User;
    public function delete(string $id) :void;
    public function forceDelete() :void;
}
