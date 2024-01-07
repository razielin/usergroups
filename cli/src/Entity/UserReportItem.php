<?php
namespace App\Entity;

class UserReportItem
{

    private int $user_id;
    private string $name;
    private string $email;
    private string $user_groups;
    public function __construct(int $user_id, string $name, string $email, string $user_groups, string $group_ids)
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->email = $email;
        $this->user_groups = $user_groups;
        $this->group_ids = $group_ids;
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

    public function getUserGroups(): string
    {
        return $this->user_groups;
    }

    public function getGroupIds(): string
    {
        return $this->group_ids;
    }

}