<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
class Group implements \JsonSerializable
{
    private int $group_id;
    private string $group_name;

    public function __construct(int $group_id = 0, string $group_name = '')
    {
        $this->group_id = $group_id;
        $this->group_name = $group_name;
    }


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
