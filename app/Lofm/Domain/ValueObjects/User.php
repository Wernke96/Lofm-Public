<?php


namespace App\Lofm\Domain\ValueObjects;


class User implements \App\Lofm\Domain\Utils\toArray
{

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $password;


    /**
     * @var string
     */
    private string $userName;



    /**
     * User constructor.
     * @param string $email
     * @param string $userName
     * @param string $password
     */
    public function __construct(
        string $email,
        string $userName,
        string $password
    ) {
        $this->email = $email;
        $this->userName = $userName;
        $this->password = $password;

    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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
     * @return array
     */
    public function toArray() :array
    {
        return [
            'email' => $this->getEmail(),
            'userName' => $this->getUserName(),
            "password" => $this->getPassword()
        ];
    }
}
