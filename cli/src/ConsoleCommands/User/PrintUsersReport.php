<?php
namespace App\ConsoleCommands\User;

use App\Api\UsersApi;
use App\ConsoleCommands\BaseCommand;
use App\Entity\UserReportItem;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class PrintUsersReport extends BaseCommand {
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
        $res = $this->usersApi->getUsersReport();
        $this->renderUsersInTable($res);
    }

    /**
     * @param UserReportItem[] $users
     * @return void
     */
    public function renderUsersInTable(array $users): void
    {
        $this->renderTable(
            ['user_id', 'name', 'email', 'user_groups', 'group_ids'],
            array_map(
                fn(UserReportItem $user) => [
                    $user->getUserId(), $user->getName(), $user->getEmail(), $user->getUserGroups(), $user->getGroupIds()
                ],
                $users
            )
        );
    }
}

