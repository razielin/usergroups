<?php

namespace App\ConsoleCommands\Group;

use App\Api\GroupApi;
use App\ConsoleCommands\BaseCommand;
use App\Entity\Group;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class AddGroupCommand extends BaseCommand
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

        while (true) {
            $group = new Group();
            $groupName = $this->askUser('Type group name', '');
            $group->setGroupName($groupName);
            try {
                $group = $this->groupApi->addGroup($group);
                if ($group) {
                    $this->printGroupsCommand->execute();
                    $this->section->writeln('User successfully added!');
                    break;
                }
            } catch (\RuntimeException $e) {
                $this->section->writeln("Error occurred: " . $e->getMessage());
            }
        }
    }
}


