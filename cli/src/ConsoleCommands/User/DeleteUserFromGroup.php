<?php
namespace App\ConsoleCommands\User;

use App\Api\GroupApi;
use App\Api\UsersApi;
use App\ConsoleCommands\BaseCommand;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class DeleteUserFromGroup extends BaseCommand {
    private PrintUsersReport $printUsersReportCommand;
    protected GroupApi $groupApi;

    public function __construct(
        ConsoleSectionOutput $section,
        UsersApi             $usersApi,
        GroupApi             $groupApi,
        PrintUsersReport     $printUsersReportCommand,
        InputInterface       $input,
        Helper               $helper
    )
    {
        parent::__construct($section, $usersApi, $input, $helper);
        $this->printUsersReportCommand = $printUsersReportCommand;
        $this->groupApi = $groupApi;
    }

    public function execute()
    {
        $this->section->clear();
        $this->printUsersReportCommand->execute();

        $userId = (int)$this->askUser('Type user_id which you to remove from');
        $user = $this->checkIfUserExists($userId);
        if (!$user) {
            $this->section->writeln('No user found with such id');
            return;
        }

        $groupId = (int)$this->askUser('Type group_id');
        $group = $this->checkIfGroupExists($groupId);
        if (!$group) {
            $this->section->writeln('No group found with such id');
            return;
        }

        try {
            $res = $this->usersApi->deleteUserFromGroup($userId, $groupId);
            if ($res) {
                $this->printUsersReportCommand->execute();
                $this->section->writeln(
                    "User #$userId has been successfully deleted from the group!"
                );
            } else {
                $this->section->writeln(
                    "User #$userId does not belong to the group #$groupId!"
                );
            }
        } catch (\RuntimeException $e) {
            $this->section->writeln("Error occurred: " . $e->getMessage());
        }
    }


}

