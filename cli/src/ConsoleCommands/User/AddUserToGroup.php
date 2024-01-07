<?php
namespace App\ConsoleCommands\User;

use App\Api\GroupApi;
use App\Api\UsersApi;
use App\ConsoleCommands\BaseCommand;
use App\ConsoleCommands\Group\PrintGroupsCommand;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class AddUserToGroup extends BaseCommand {
    private PrintUsersCommand $printUsersCommand;
    private PrintUsersReport $printUsersReportCommand;
    private PrintGroupsCommand $printGroupsCommand;
    protected GroupApi $groupApi;

    public function __construct(
        ConsoleSectionOutput $section,
        UsersApi             $usersApi,
        GroupApi             $groupApi,
        PrintUsersCommand    $printUsersCommand,
        PrintUsersReport     $printUsersReportCommand,
        PrintGroupsCommand   $printGroupsCommand,
        InputInterface       $input,
        Helper               $helper
    )
    {
        parent::__construct($section, $usersApi, $input, $helper);
        $this->printUsersCommand = $printUsersCommand;
        $this->printUsersReportCommand = $printUsersReportCommand;
        $this->printGroupsCommand = $printGroupsCommand;
        $this->groupApi = $groupApi;
    }

    public function execute()
    {
        $this->section->clear();
        $this->printUsersCommand->execute();

        $userId = (int)$this->askUser('Type user_id which you want to add group');
        $user = $this->checkIfUserExists($userId);
        if (!$user) {
            $this->section->writeln('No user found with such id');
            return;
        }

        $this->printGroupsCommand->execute();
        $groupId = (int)$this->askUser('Type group_id');
        $group = $this->checkIfGroupExists($groupId);
        if (!$group) {
            $this->section->writeln('No group found with such id');
            return;
        }

        try {
            $res = $this->usersApi->addUserToGroup($userId, $groupId);
            if ($res) {
                $this->printUsersReportCommand->execute();
                $this->section->writeln(
                    "User #$userId has been successfully added to the group!"
                );
            } else {
                $this->section->writeln(
                    "User #$userId already belongs to the group #$groupId!"
                );
            }
        } catch (\RuntimeException $e) {
            $this->section->writeln("Error occurred: " . $e->getMessage());
        }
    }
}

