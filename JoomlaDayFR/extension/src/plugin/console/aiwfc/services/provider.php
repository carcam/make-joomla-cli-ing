
<?php

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Noel\Plugin\Console\Aiwfc\Extension\AiwfcConsolePlugin;

return new class () implements ServiceProviderInterface {
    public function register(Container $container)
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {

                $dispatcher = $container->get(DispatcherInterface::class);

                $plugin = new AiwfcConsolePlugin(
                    $dispatcher,
                    (array) PluginHelper::getPlugin('console', 'aiwfc')
                );
                return $plugin;
            }
        );
    }
};
