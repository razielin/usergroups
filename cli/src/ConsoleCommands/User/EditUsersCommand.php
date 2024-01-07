<?php
namespace App\ConsoleCommands\User;

use App\Api\UsersApi;
use App\ConsoleCommands\BaseCommand;
use App\Entity\User;
use App\Utils\ArrayUtils;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class EditUsersCommand extends BaseCommand {
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
        $this->printUsersCommand->execute();
        $users = $this->usersApi->getUsers();

        $userId = $this->askUser('Type user_id which you want to edit');
        $user = ArrayUtils::find($users, fn(User $user) => $user->getUserId() === (int)$userId);
        if (!$user) {
            $this->section->writeln('No user found with such id');
            return;
        }
        while (true) {
            $userName = $this->askUser('Type user name', $user->getName());
            $user->setName($userName);
            $userEmail = $this->askUser('Type user email', $user->getEmail());
            $user->setEmail($userEmail);
            try {
                $user = $this->usersApi->editUser($user);
                if ($user) {
                    $this->printUsersCommand->execute();
                    $this->section->writeln('User successfully saved!');
                    break;
                }
            } catch (\RuntimeException $e) {
                $this->section->writeln("Error occurred: " . $e->getMessage());
            }
        }
    }
}

