<?php

namespace App;

//use Symfony\Component\Console\Application;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;
use Symfony\Component\Console\Command\CompleteCommand;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\HttpKernel\KernelInterface;

class TerminalApplication extends Application
{
    public function __construct(
         KernelInterface $kernel,
//        CommandLoaderInterface $commandLoader
    )
    {
//        parent::__construct('Empiriq Terminal', '1.0.0');
        parent::__construct($kernel);
        $this->setAutoExit(false);
//        $this->setCommandLoader($commandLoader);
    }

    protected function getDefaultCommands(): array
    {
        return [
            new HelpCommand(),
            new ListCommand(),
            new CompleteCommand(),
        ];
    }

    protected function getDefaultInputDefinition(): InputDefinition
    {
        $definition = parent::getDefaultInputDefinition();
        $definition->setOptions([]);

        return $definition;
    }
}
