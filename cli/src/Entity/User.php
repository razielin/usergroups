<?php
namespace App\Entity;

class User implements \JsonSerializable
{
    private int $user_id;
    private string $name;
    private string $email;

    public function __construct(int $user_id = 0, string $name = '', string $email = '')
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function jsonSerialize()
    {
        return [
            'user_id' => $this->user_id,
            'name'  => $this->name,
            'email' => $this->email,
        ];
    }
}
