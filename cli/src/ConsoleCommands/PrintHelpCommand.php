<?php
namespace App\ConsoleCommands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

class PrintHelpCommand extends BaseCommand {
    protected ConsoleSectionOutput $section;
    public function __construct(ConsoleSectionOutput $section)
    {
        $this->section = $section;
    }


    public function execute()
    {
        $this->section->clear();
        $this->section->writeln("Type one of the command name below or type 'exit':");
        foreach (CommandFactory::AVAILABLE_COMMANDS as $command) {
            $this->section->writeln($command);
        }
    }
}

