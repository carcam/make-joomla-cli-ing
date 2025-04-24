<?php

namespace AwCo\Plugin\Console\ClearTodoList\CliCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Joomla\Console\Command\AbstractCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Joomla\Database\DatabaseInterface;
use Joomla\CMS\Factory;
use Symfony\Component\Console\Input\InputOption;

class TaskDeadlineCommand extends AbstractCommand
{
    protected static $defaultName = 'ctl:deadline';

    protected function configure(): void
    {
        $this->setDescription('Check the deadlines for your tasks.');
        $this->setHelp('Execute task:deadline to check the deadlines for your tasks.');
    }

    protected function getDeadlines(): array
    {
        $deadlines = [];

        $days = 42;

        $db = Factory::getContainer()->get(DatabaseInterface::class);

        $query = $db->createQuery();
        $query->select('*')
            ->from('#__awco_ctl_tasks');

        $query->where('deadline BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL ' . $days . ' DAY)');

        $db->setQuery($query);

        $deadlines = $db->loadAssocList('id');

        return $deadlines;
    }

    protected function doExecute(InputInterface $input, OutputInterface $output): int
    {
        $outputStyle = new SymfonyStyle($input, $output);
        $outputStyle->title('Upcoming deadlines for your tasks');

        $deadlines = $this->getDeadlines();

        $this->showDeadlines($outputStyle, $deadlines);

        return Command::SUCCESS;
    }

    protected function showDeadlines($outputStyle, $deadlines)
    {
        if (empty($deadlines)) {
            $outputStyle->note('There are no upcoming deadlines for your tasks.');
        } else {
            $outputStyle->table(['Id', 'Task', 'Status', 'Description', 'Deadline', 'Created by'], $deadlines);
        }
    }
}
