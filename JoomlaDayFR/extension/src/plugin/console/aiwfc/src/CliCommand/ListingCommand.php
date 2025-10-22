<?php

namespace Noel\Plugin\Console\Aiwfc\CliCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Command\Command;
use Joomla\Console\Command\AbstractCommand;
use Joomla\CMS\Factory;
use Joomla\Database\DatabaseInterface;

class ListingCommand extends AbstractCommand
{
    protected static $defaultName = 'aiwfc:listing';

    protected function configure(): void
    {
        $this->setDescription('Vérifiez les dates limites de vos souhaits.');
        $this->setHelp('Exécutez aiwfc:listing pour vérifier les souhaits.');

        $this->addOptions();
    }

    protected function addOptions()
    {
        $description = 'Cochez uniquement les souhaits datant de ce nombre de jours.';
        $this->addOption('jours', 'j', InputOption::VALUE_OPTIONAL, $description, 7);

        return;
    }

    protected function getWishes($options): array
    {
        $wishes = [];

        $days = (int)$options['jours'];
        if ($days <= 0) {
            $days = 7;
        }

        $db = Factory::getContainer()->get(DatabaseInterface::class);

        $query = $db->createQuery();
        $query->select('*')
            ->from('#__aiwfc_souhaits');
        $query->where('cree_le BETWEEN DATE_SUB(NOW(), INTERVAL ' . $days . ' DAY) AND NOW()');

        $db->setQuery($query);

        $wishes = $db->loadAssocList('id');

        return $wishes;
    }

    protected function doExecute(InputInterface $input, OutputInterface $output): int
    {
        $outputStyle = new SymfonyStyle($input, $output);

        $outputStyle->title('Vos souhaits');

        $options = $this->getOptions($input);

        $wishes = $this->getWishes($options);

        $this->showWishes($outputStyle, $wishes);

        return Command::SUCCESS;
    }

    protected function getOptions($input): array
    {
        $options = [];

        $options = $input->getOptions();

        return $options;
    }

    protected function showWishes($outputStyle, $wishes)
    {
        if (empty($wishes)) {
            $outputStyle->note('There are no upcoming wishes for your tasks.');
        } else {
            $outputStyle->table(['Id', 'Souhait', 'État', 'Description', 'Créé en', 'Créé par'], $wishes);
        }
    }

}
