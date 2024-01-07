<?php
namespace App\ConsoleCommands\Group;

use App\Api\GroupApi;
use App\Api\UsersApi;
use App\ConsoleCommands\BaseCommand;
use App\Entity\GroupReportItem;
use App\Entity\UserReportItem;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class PrintGroupsReport extends BaseCommand {
    protected ConsoleSectionOutput $section;
    protected GroupApi $groupApi;
    public function __construct(ConsoleSectionOutput $section, GroupApi $groupApi)
    {
        $this->section = $section;
        $this->groupApi = $groupApi;
    }

    public function execute()
    {
        $this->section->clear();
        $res = $this->groupApi->getGroupReport();
        $this->renderUsersInTable($res);
    }

    /**
     * @param GroupReportItem[] $users
     * @return void
     */
    public function renderUsersInTable(array $users): void
    {
        $this->renderTable(
            ['group_id', 'group_name', 'group_users'],
            array_map(
                fn(GroupReportItem $user) => [$user->getGroupId(), $user->getGroupName(), $user->getGroupUsers()],
                $users
            )
        );
    }
}

