<?php
namespace App\DTO;

class UserReportItem
{

    public int $user_id;
    public string $name;
    public string $email;
    public string $user_groups;
    public string $group_ids;
    public function __construct(int $user_id, string $name, string $email, string $user_groups, string $group_ids)
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->email = $email;
        $this->user_groups = $user_groups;
        $this->group_ids = $group_ids;
    }
}