<?php
namespace App\ConsoleCommands\User;

use App\Api\UsersApi;
use App\ConsoleCommands\BaseCommand;
use App\Entity\User;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class AddUserCommand extends BaseCommand {
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
            $user = new User();
            $userName = $this->askUser('Type user name', '');
            $user->setName($userName);
            $userEmail = $this->askUser('Type user email', '');
            $user->setEmail($userEmail);
            try {
                $user = $this->usersApi->addUser($user);
                if ($user) {
                    $this->printUsersCommand->execute();
                    $this->section->writeln('User successfully added!');
                    break;
                }
            } catch (\RuntimeException $e) {
                $this->section->writeln("Error occurred: " . $e->getMessage());
            }
        }
    }
}

