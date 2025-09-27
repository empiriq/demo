<?php

namespace App;

//use Symfony\Component\Console\Application;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\CompleteCommand;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\HttpKernel\KernelInterface;

final class TerminalApplication extends Application
{
    public function __construct(
        KernelInterface $kernel,
    ) {
        parent::__construct($kernel);
        $this->setAutoExit(false);
    }

    #[\Override]
    protected function getDefaultCommands(): array
    {
        return [
            new HelpCommand(),
            new ListCommand(),
            new CompleteCommand(),
        ];
    }

    #[\Override]
    protected function getDefaultInputDefinition(): InputDefinition
    {
        $definition = parent::getDefaultInputDefinition();
        $definition->setOptions([]);

        return $definition;
    }
}
