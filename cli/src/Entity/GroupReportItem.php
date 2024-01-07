<?php
namespace App\Entity;

class GroupReportItem
{

    private int $group_id;
    private string $group_name;
    private string $group_users;
    public function __construct(int $group_id, string $group_name, string $group_users)
    {
        $this->group_id = $group_id;
        $this->group_name = $group_name;
        $this->group_users = $group_users;
    }

    public function getGroupId(): int
    {
        return $this->group_id;
    }

    public function getGroupName(): string
    {
        return $this->group_name;
    }

    public function getGroupUsers(): string
    {
        return $this->group_users;
    }


}