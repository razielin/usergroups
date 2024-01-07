<?php
namespace App\Api;

use App\Entity\Group;
use App\Entity\GroupReportItem;
use App\Entity\UserReportItem;

class GroupApi extends BaseApi
{
    /**
     * @return Group[]
     */
    public function getGroups(): array
    {
        $groups = $this->getServerResponse(self::SERVER_URL . '/groups');
        return array_map(fn(array $user) => new Group($user['group_id'], $user['group_name']), $groups);
    }

    public function editGroup(Group $group)
    {
        $group = $this->getServerResponse(self::SERVER_URL . '/groups/edit', $group);
        return $group;
    }

    public function addGroup(Group $group)
    {
        $group = $this->getServerResponse(self::SERVER_URL . '/groups/add', $group);
        return $group;
    }

    public function deleteGroup(int $group_id)
    {
        return $this->getServerResponse(self::SERVER_URL . '/groups/delete', ['group_id' => $group_id]);
    }

    /**
     * @return GroupReportItem[]
     */
    public function getGroupReport(): array
    {
        $res = $this->getServerResponse(self::SERVER_URL . '/groups/report');
        return array_map(
            fn(array $group) => new GroupReportItem(
                $group['group_id'], $group['group_name'], $group['group_users']
            ),
            $res
        );
    }
}
