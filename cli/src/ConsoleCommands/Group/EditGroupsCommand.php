<?php

namespace App\ConsoleCommands\Group;

use App\Api\GroupApi;
use App\ConsoleCommands\BaseCommand;
use App\Entity\Group;
use App\Utils\ArrayUtils;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class EditGroupsCommand extends BaseCommand
{
    private PrintGroupsCommand $printGroupsCommand;

    protected ConsoleSectionOutput $section;
    private GroupApi $groupApi;
    protected InputInterface $input;
    protected Helper $helper;

    /**
     * @param PrintGroupsCommand $printGroupsCommand
     * @param ConsoleSectionOutput $section
     * @param GroupApi $groupApi
     * @param InputInterface $input
     * @param Helper $helper
     */
    public function __construct(PrintGroupsCommand $printGroupsCommand, ConsoleSectionOutput $section, GroupApi $groupApi, InputInterface $input, Helper $helper)
    {
        $this->printGroupsCommand = $printGroupsCommand;
        $this->section = $section;
        $this->groupApi = $groupApi;
        $this->input = $input;
        $this->helper = $helper;
    }


    public function execute()
    {
        $this->section->clear();
        $this->printGroupsCommand->execute();
        $groups = $this->groupApi->getGroups();

        $groupId = $this->askUser('Type group_id which you want to edit');
        /** @var Group $group */
        $group = ArrayUtils::find($groups, fn(Group $group) => $group->getGroupId() === (int)$groupId);
        if (!$group) {
            $this->section->writeln('No group found with such id');
            return;
        }
        while (true) {
            $userName = $this->askUser('Type group name', $group->getGroupName());
            $group->setGroupName($userName);
            try {
                $group = $this->groupApi->editGroup($group);
                if ($group) {
                    $this->printGroupsCommand->execute();
                    $this->section->writeln('Group successfully saved!');
                    break;
                }
            } catch (\RuntimeException $e) {
                $this->section->writeln("Error occurred: " . $e->getMessage());
            }
        }
    }
}


