<?php
namespace App\ConsoleCommands;

use App\Api\UsersApi;
use App\Entity\Group;
use App\Entity\User;
use App\Utils\ArrayUtils;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Question\Question;

abstract class BaseCommand {

    protected ConsoleSectionOutput $section;
    protected UsersApi $usersApi;
    protected InputInterface $input;
    protected Helper $helper;

    public function __construct(ConsoleSectionOutput $section, UsersApi $usersApi, InputInterface $input, Helper $helper)
    {
        $this->section = $section;
        $this->usersApi = $usersApi;
        $this->input = $input;
        $this->helper = $helper;
    }

    abstract public function execute();

    /**
     * @return mixed
     */
    protected function askUser(string $message, $default = null)
    {
        $question = new Question($message, $default);
        return $this->helper->ask($this->input, $this->section, $question);
    }

    protected function renderTable(array $headers, array $rows): void
    {
        $table = new Table($this->section);
        $table
            ->setHeaders($headers)
            ->setRows($rows);
        $table->render();
    }

    /**
     * @param int $userId
     * @return User|null
     */
    protected function checkIfUserExists(int $userId): ?User
    {
        $users = $this->usersApi->getUsers();
        $user = ArrayUtils::find($users, fn(User $user) => $user->getUserId() === $userId);
        return $user;
    }

    /**
     * @param int $groupId
     * @return Group|null
     */
    protected function checkIfGroupExists(int $groupId): ?Group
    {
        $groups = $this->groupApi->getGroups();
        $group = ArrayUtils::find($groups, fn(Group $group) => $group->getGroupId() === $groupId);
        return $group;
    }
}

