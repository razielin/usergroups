<?php
namespace App\ConsoleCommands;

use App\Api\GroupApi;
use App\Api\UsersApi;
use App\ConsoleCommands\Group\AddGroupCommand;
use App\ConsoleCommands\Group\EditGroupsCommand;
use App\ConsoleCommands\Group\PrintGroupsCommand;
use App\ConsoleCommands\Group\DeleteGroupCommand;
use App\ConsoleCommands\Group\PrintGroupsReport;
use App\ConsoleCommands\User\AddUserCommand;
use App\ConsoleCommands\User\AddUserToGroup;
use App\ConsoleCommands\User\DeleteUserCommand;
use App\ConsoleCommands\User\DeleteUserFromGroup;
use App\ConsoleCommands\User\EditUsersCommand;
use App\ConsoleCommands\User\PrintUsersCommand;
use App\ConsoleCommands\User\PrintUsersReport;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class CommandFactory
{
    const AVAILABLE_COMMANDS = [
        self::USERS_PRINT,
        self::USERS_REPORT,
        self::USERS_ADD_TO_GROUP,
        self::USERS_DELETE_FROM_GROUP,
        self::USERS_ADD,
        self::USERS_EDIT,
        self::USERS_DELETE,
        self::GROUPS_PRINT,
        self::GROUPS_ADD,
        self::GROUPS_EDIT,
        self::GROUPS_DELETE,
        self::GROUPS_REPORT,
        self::HELP,
        self::EXIT,
    ];
    const USERS_PRINT = "users:print";
    const USERS_ADD = "users:add";
    const USERS_EDIT = "users:edit";
    const USERS_DELETE = "users:delete";
    const USERS_REPORT = "users:report";
    const USERS_ADD_TO_GROUP = "users:add_to_group";
    const USERS_DELETE_FROM_GROUP = "users:delete_from_group";
    const GROUPS_PRINT = "groups:print";
    const GROUPS_ADD = "groups:add";
    const GROUPS_EDIT = "groups:edit";
    const GROUPS_DELETE = "groups:delete";
    const GROUPS_REPORT = "groups:report";
    const HELP = "help";
    const EXIT = "exit";

    private ConsoleSectionOutput $section;
    private InputInterface $input;
    private Helper $helper;
    private UsersApi $usersApi;
    private GroupApi $groupApi;

    public function __construct(
        ConsoleSectionOutput $section, InputInterface $input, Helper $helper, UsersApi $usersApi, GroupApi $groupApi
    )
    {
        $this->section = $section;
        $this->input = $input;
        $this->helper = $helper;
        $this->usersApi = $usersApi;
        $this->groupApi = $groupApi;
    }

    public function make(string $commandName): ?BaseCommand
    {
        $printUsersCommand = new PrintUsersCommand($this->section, $this->usersApi);
        $printGroupsCommand = new PrintGroupsCommand($this->section, $this->groupApi);
        switch ($commandName) {
            case self::GROUPS_PRINT:
                return new PrintGroupsCommand($this->section, $this->groupApi);
            case self::USERS_REPORT:
                return new PrintUsersReport($this->section, $this->usersApi);
            case self::GROUPS_REPORT:
                return new PrintGroupsReport($this->section, $this->groupApi);
            case self::USERS_PRINT:
                return new PrintUsersCommand($this->section, $this->usersApi);
            case self::HELP:
                return new PrintHelpCommand($this->section);
            case self::USERS_ADD_TO_GROUP:
                return new AddUserToGroup(
                    $this->section,
                    $this->usersApi,
                    $this->groupApi,
                    $printUsersCommand,
                    new PrintUsersReport($this->section, $this->usersApi),
                    new PrintGroupsCommand($this->section, $this->groupApi),
                    $this->input,
                    $this->helper
                );
            case self::USERS_DELETE_FROM_GROUP:
                return new DeleteUserFromGroup(
                    $this->section,
                    $this->usersApi,
                    $this->groupApi,
                    new PrintUsersReport($this->section, $this->usersApi),
                    $this->input,
                    $this->helper
                );
            case self::USERS_EDIT:
                return new EditUsersCommand($this->section, $this->usersApi, $printUsersCommand, $this->input, $this->helper);
            case self::USERS_ADD:
                return new AddUserCommand($this->section, $this->usersApi, $printUsersCommand, $this->input, $this->helper);
            case self::USERS_DELETE:
                return new DeleteUserCommand($this->section, $this->usersApi, $printUsersCommand, $this->input, $this->helper);
            case self::GROUPS_EDIT:
                return new EditGroupsCommand($printGroupsCommand, $this->section, $this->groupApi, $this->input, $this->helper);
            case self::GROUPS_ADD:
                return new AddGroupCommand($printGroupsCommand, $this->section, $this->groupApi, $this->input, $this->helper);
            case self::GROUPS_DELETE:
                return new DeleteGroupCommand($printGroupsCommand, $this->section, $this->groupApi, $this->input, $this->helper);

            default:
                $this->section->writeln('command not found');
                return new PrintHelpCommand($this->section);
        }
    }
}
