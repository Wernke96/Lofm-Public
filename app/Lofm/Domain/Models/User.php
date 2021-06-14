<?php


namespace App\Lofm\Domain\Models;


use App\Lofm\Domain\Utils\toArray;
use Carbon\Carbon;

/**
 * Class User
 * @package App\Lofm\Domain\Models
 */
class User implements toArray
{

    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string|null
     */
    private ?string $email_verified_at;

    /**
     * @var string
     */
    private string $userName;

    /**
     * @var Carbon
     */
    private Carbon $created_at;

    /**
     * @var Carbon
     */
    private Carbon $updated_at;



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
    public function __construct(
        string $id,
        string $email,
        string $password,
        ?string $email_verified_at,
        string $userName,
        Carbon $created_at,
        Carbon $updated_at
    )
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->email_verified_at = $email_verified_at;
        $this->userName = $userName;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getEmailVerifiedAt(): ?string
    {
        return $this->email_verified_at;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'email_verified_at' => $this->getEmailVerifiedAt(),
            'userName' => $this->getUserName(),
            "password" => $this->getPassword(),
            "created_at" => $this->getCreatedAt(),
            "updated_at" => $this->getUpdatedAt()
        ];
    }
}
