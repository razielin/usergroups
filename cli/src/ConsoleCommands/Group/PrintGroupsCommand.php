<?php

namespace App\ConsoleCommands\Group;

use App\Api\GroupApi;
use App\ConsoleCommands\BaseCommand;
use App\Entity\Group;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class PrintGroupsCommand extends BaseCommand
{
    protected ConsoleSectionOutput $section;
    protected GroupApi $groupApi;

    public function __construct(ConsoleSectionOutput $section, GroupApi $groupApi)
    {
        $this->section = $section;
        $this->groupApi = $groupApi;
    }

    public function execute()
    {
        $this->section->clear();
        $res = $this->groupApi->getGroups();
        $this->renderGroupsInTable($res);
    }

    /**
     * @param Group[] $groups
     * @return void
     */
    public function renderGroupsInTable(array $groups): void
    {
        $this->renderTable(
            ['group_id', 'group_name'],
            array_map(fn(Group $group) => [$group->getGroupId(), $group->getGroupName()], $groups)
        );
    }
}


