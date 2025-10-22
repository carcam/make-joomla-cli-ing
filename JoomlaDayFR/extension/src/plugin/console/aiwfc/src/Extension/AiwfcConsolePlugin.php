<?php

namespace Noel\Plugin\Console\Aiwfc\Extension;

use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Application\ApplicationEvents;
use Joomla\Application\Event\ApplicationEvent;
use Noel\Plugin\Console\Aiwfc\CliCommand\ListingCommand;

class AiwfcConsolePlugin extends CMSPlugin implements SubscriberInterface
{
    protected $autoloadLanguage = true;

    public static function getSubscribedEvents(): array
    {
        return [
            ApplicationEvents::BEFORE_EXECUTE => 'registerCLICommands'
        ];
    }

    public function registerCLICommands(ApplicationEvent $event): void
    {
        $app = $event->getApplication();

        $app->addCommand(new ListingCommand());
    }
}
