<?php
namespace App\Service;

use App\Entity\Group;
use App\Entity\User;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService extends BaseService
{
    private UserRepository $userRepository;
    private GroupRepository $groupRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, GroupRepository $groupRepository, ValidatorInterface $validator)
    {
        parent::__construct($validator);
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
    }


    /**
     * @param string $name
     * @param string $email
     * @return User
     * @throws ValidationException
     */
    public function addUser(string $name, string $email): User
    {
        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $this->validateOrThrow($user);

        $this->userRepository->add($user);
        return $user;
    }

    /**
     * @param int $user_id
     * @param string $name
     * @param string $email
     * @return User
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function editUser(int $user_id, string $name, string $email): User
    {
        $user = $this->findUserOrThrow($user_id);
        $user->setName($name);
        $user->setEmail($email);

        $this->validateOrThrow($user);
        $this->userRepository->add($user);
        return $user;
    }

    /**
     * @param int $user_id
     * @return void
     * @throws NotFoundException
     */
    public function deleteUser(int $user_id): void
    {
        $user = $this->findUserOrThrow($user_id);
        $this->userRepository->remove($user);
    }

    public function allUsers(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param $user_id
     * @return User
     * @throws NotFoundException
     */
    protected function findUserOrThrow($user_id): User
    {
        $user = $this->userRepository->find($user_id);
        if (!$user) {
            throw new NotFoundException("user #$user_id not found");
        }
        return $user;
    }

    /**
     * @param $group_id
     * @return Group
     * @throws NotFoundException
     */
    protected function findGroupOrThrow($group_id): Group
    {
        $group = $this->groupRepository->find($group_id);
        if (!$group) {
            throw new NotFoundException("group #$group_id not found");
        }
        return $group;
    }

    public function getUsersWithGroups(): array
    {
        return $this->userRepository->getUsersWithGroups();
    }

    /**
     * @param int $userId
     * @param int $groupId
     * @return User
     * @throws NotFoundException
     */
    public function addUserGroup(int $userId, int $groupId): bool
    {
        $user = $this->findUserOrThrow($userId);
        $group = $this->findGroupOrThrow($groupId);
        $res = $user->addGroup($group);
        $this->userRepository->add($user);
        return $res;
    }

    /**
     * @param int $userId
     * @param int $groupId
     * @return User
     * @throws NotFoundException
     */
    public function deleteUserGroup(int $userId, int $groupId): bool
    {
        $user = $this->findUserOrThrow($userId);
        $group = $this->findGroupOrThrow($groupId);
        $res = $user->removeGroup($group);
        $this->userRepository->add($user);
        return $res;
    }
}
