<?php

namespace AwCo\Plugin\Console\ClearTodoList\Extension;

use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Application\ApplicationEvents;
use Joomla\Application\Event\ApplicationEvent;
use AwCo\Plugin\Console\ClearTodoList\CliCommand\TaskDeadlineCommand;

class TaskConsolePlugin extends CMSPlugin implements SubscriberInterface
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

        $app->addCommand(new TaskDeadlineCommand());
    }
}
