<?php
namespace App\ConsoleCommands\User;

use App\Api\UsersApi;
use App\ConsoleCommands\BaseCommand;
use App\Entity\User;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class PrintUsersCommand extends BaseCommand {
    protected ConsoleSectionOutput $section;
    protected UsersApi $usersApi;
    public function __construct(ConsoleSectionOutput $section, UsersApi $usersApi)
    {
        $this->section = $section;
        $this->usersApi = $usersApi;
    }

    public function execute()
    {
        $this->section->clear();
        $res = $this->usersApi->getUsers();
        $this->renderUsersInTable($res);
    }

    /**
     * @param User[] $users
     * @return void
     */
    public function renderUsersInTable(array $users): void
    {
        $this->renderTable(
            ['user_id', 'name', 'email'],
            array_map(fn(User $user) => [$user->getUserId(), $user->getName(), $user->getEmail()], $users)
        );
    }
}

