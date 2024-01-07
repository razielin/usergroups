<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $user_id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $name;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    /**
     * @var Group[]
     */
    #[JoinTable(name: 'user_groups')]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'user_id')]
    #[InverseJoinColumn(name: 'group_id', referencedColumnName: 'group_id')]
    #[ManyToMany(targetEntity: Group::class)]
    private Collection $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getGroups(): array|Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): bool
    {
        $found = $this->getGroupById($group);
        if (!$found) {
            $this->groups->add($group);
            return true;
        }
        return false;
    }

    public function removeGroup(Group $group): bool
    {
        $found = $this->getGroupById($group);
        if (!$found) {
            return false;
        }
        $this->groups = $this->groups->filter(fn(Group $g) => $g->getGroupId() !== $group->getGroupId());
        return true;
    }

    /**
     * @param Group $group
     * @return Group|null
     */
    private function getGroupById(Group $group): ?Group
    {
        foreach ($this->groups->toArray() as $g) {
            if ($g->getGroupId() === $group->getGroupId()) {
                return $g;
            }
        }
        return null;
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
