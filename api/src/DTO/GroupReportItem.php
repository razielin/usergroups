<?php
namespace App\DTO;

class GroupReportItem
{

    public int $group_id;
    public string $group_name;
    public string $group_users;
    public function __construct(int $group_id, string $group_name, string $group_users)
    {
        $this->group_id = $group_id;
        $this->group_name = $group_name;
        $this->group_users = $group_users;
    }
}