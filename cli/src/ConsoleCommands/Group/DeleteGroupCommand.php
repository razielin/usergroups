<?php

namespace App\ConsoleCommands\Group;

use App\Api\GroupApi;
use App\ConsoleCommands\BaseCommand;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class DeleteGroupCommand extends BaseCommand
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
            $this->printGroupsCommand->execute();
            $groupId = (int)$this->askUser('Type group_id which you want to delete');
            try {
                $res = $this->groupApi->deleteGroup($groupId);
                if ($res) {
                    $this->printGroupsCommand->execute();
                    $this->section->writeln('Group successfully deleted!');
                } else {
                    $this->section->writeln('Group not found!');
                }
                break;
            } catch (\RuntimeException $e) {
                $this->section->writeln("Error occurred: " . $e->getMessage());
            }
        }
    }
}


