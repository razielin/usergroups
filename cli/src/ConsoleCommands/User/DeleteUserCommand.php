<?php
namespace App\ConsoleCommands\User;

use App\Api\UsersApi;
use App\ConsoleCommands\BaseCommand;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class DeleteUserCommand extends BaseCommand {
    private PrintUsersCommand $printUsersCommand;

    public function __construct(
        ConsoleSectionOutput $section,
        UsersApi $usersApi,
        PrintUsersCommand $printUsersCommand,
        InputInterface $input,
        Helper $helper
    )
    {
        parent::__construct($section, $usersApi, $input, $helper);
        $this->printUsersCommand = $printUsersCommand;
    }

    public function execute()
    {
        $this->section->clear();

        while (true) {
            $this->printUsersCommand->execute();
            $userId = (int)$this->askUser('Type user_id which you want to delete');
            try {
                $res = $this->usersApi->deleteUser($userId);
                if ($res) {
                    $this->printUsersCommand->execute();
                    $this->section->writeln('User successfully deleted!');
                } else {
                    $this->section->writeln('User not found!');
                }
                break;
            } catch (\RuntimeException $e) {
                $this->section->writeln("Error occurred: " . $e->getMessage());
            }
        }
    }
}

