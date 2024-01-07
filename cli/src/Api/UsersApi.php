<?php
namespace App\Api;

use App\Entity\UserReportItem;
use App\Entity\User;

class UsersApi extends BaseApi
{
    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        $users = $this->getServerResponse(self::SERVER_URL . '/users');
        return array_map(fn(array $user) => new User($user['user_id'], $user['name'], $user['email']), $users);
    }

    public function editUser(User $user)
    {
        $user = $this->getServerResponse(self::SERVER_URL . '/users/edit', $user);
        return $user;
    }

    public function addUser(User $user)
    {
        $user = $this->getServerResponse(self::SERVER_URL . '/users/add', $user);
        return $user;
    }

    public function deleteUser(int $user_id)
    {
        return $this->getServerResponse(self::SERVER_URL . '/users/delete', ['user_id' => $user_id]);
    }

    /**
     * @return UserReportItem[]
     */
    public function getUsersReport(): array
    {
        $res =  $this->getServerResponse(self::SERVER_URL . '/users/report');
        return array_map(
            fn(array $user) => new UserReportItem(
                $user['user_id'], $user['name'], $user['email'], $user['user_groups'], $user['group_ids']
            ),
            $res
        );
    }

    public function addUserToGroup(int $user_id, int $group_id)
    {
        return $this->getServerResponse(self::SERVER_URL . '/users/groups/add', [
            'user_id' => $user_id,
            'group_id' => $group_id,
        ]);
    }

    public function deleteUserFromGroup(int $user_id, int $group_id)
    {
        return $this->getServerResponse(self::SERVER_URL . '/users/groups/delete', [
            'user_id' => $user_id,
            'group_id' => $group_id,
        ]);
    }
}
