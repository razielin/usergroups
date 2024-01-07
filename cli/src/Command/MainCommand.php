<?php
namespace App\Command;

use App\Api\GroupApi;
use App\Api\UsersApi;
use App\ConsoleCommands\CommandFactory;
use App\ConsoleCommands\PrintHelpCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:cli',
    description: '',
    hidden: false,
)]
class MainCommand extends Command
{

    protected static $defaultName = 'app:cli';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $section = $output->section();
        $this->printHelp($section);
        $section->writeln('Type a command name or press Enter to show help');

        while (true) {
            $helper = $this->getHelper('question');
            $question = new Question('Please type a name of the command: ');
            $commandFactory = new CommandFactory($section, $input, $helper, new UsersApi(), new GroupApi());
            $commandName = (string)$helper->ask($input, $output, $question);
            $section->clear();

            if ($commandName === 'exit') {
                $section->writeln('Bye!');
                break;
            }
            $command = $commandFactory->make(trim($commandName));
            if ($command) {
                $command->execute();
            } else {
                $section->writeln('command not found');
            }
        }

        return Command::SUCCESS;
    }

    private function printHelp(ConsoleSectionOutput $section): void
    {
        (new PrintHelpCommand($section))->execute();
    }
}
