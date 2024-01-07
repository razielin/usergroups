<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`groups`')]
class Group implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $group_id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $group_name;

    public function getGroupId(): int
    {
        return $this->group_id;
    }

    public function setGroupId(int $group_id): static
    {
        $this->group_id = $group_id;

        return $this;
    }

    public function getGroupName(): string
    {
        return $this->group_name;
    }

    public function setGroupName(string $group_name): static
    {
        $this->group_name = $group_name;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'group_id' => $this->group_id,
            'group_name'  => $this->group_name,
        ];
    }
}
