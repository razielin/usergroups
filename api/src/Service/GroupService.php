<?php
namespace App\Service;

use App\Entity\Group;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Repository\GroupRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GroupService extends BaseService
{
    private GroupRepository $groupRepository;

    /**
     * @param GroupRepository $groupRepository
     * @param ValidatorInterface $validator
     */
    public function __construct(GroupRepository $groupRepository, ValidatorInterface $validator)
    {
        $this->groupRepository = $groupRepository;
        parent::__construct($validator);
    }


    /**
     * @param string $group_name
     * @return Group
     * @throws ValidationException
     */
    public function addGroup(string $group_name): Group
    {
        $group = new Group();
        $group->setGroupName($group_name);
        $this->validateOrThrow($group);
        $this->groupRepository->add($group);
        return $group;
    }

    /**
     * @param string $group_id
     * @param string $group_name
     * @return Group
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function editGroup(string $group_id, string $group_name): Group
    {
        $group = $this->findGroupOrThrow($group_id);
        $group->setGroupName($group_name);
        $this->validateOrThrow($group);
        $this->groupRepository->add($group);
        return $group;
    }

    /**
     * @param int $group_id
     * @return void
     * @throws NotFoundException
     */
    public function deleteGroup(int $group_id): void
    {
        $group = $this->findGroupOrThrow($group_id);
        $this->groupRepository->remove($group);
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

    public function allGroups(): array
    {
        return $this->groupRepository->findAll();
    }

    public function getGroupsWithUsers(): array
    {
        return $this->groupRepository->getGroupsWithUsers();
    }
}
