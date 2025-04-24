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

        $this->addOptions();
    }

    protected function addOptions()
    {
        $description = 'Days in the future to check for deadlines.';
        $this->addOption('days', 'd', InputOption::VALUE_OPTIONAL, $description, 7);

        return;
    }

    protected function getDeadlines($options): array
    {
        $deadlines = [];
        $days = (int)$options['days'];
        if ($days <= 0) {
            $days = 7;
        }

        $db = Factory::getContainer()->get(DatabaseInterface::class);

        $query = $db->createQuery();
        $query->select('*')
            ->from('#__awco_ctl_tasks');

        $query->where('deadline BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL ' . $days . ' DAY)');

        $db->setQuery($query);

        $deadlines = $db->loadAssocList('id');

        return $deadlines;
    }

    protected function getOptions($input): array
    {
        $options = [];

        $options = $input->getOptions();

        return $options;
    }


    protected function doExecute(InputInterface $input, OutputInterface $output): int
    {
        $outputStyle = new SymfonyStyle($input, $output);
        $outputStyle->title('Upcoming deadlines for your tasks');

        $options = $this->getOptions($input);

        $deadlines = $this->getDeadlines($options);

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
