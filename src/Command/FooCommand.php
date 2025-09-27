<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'foo',
    description: 'Foo Description',
)]
final class FooCommand extends Command
{
    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('yeee!');

        return 0;
    }
}
