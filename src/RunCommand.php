<?php

namespace App;

use Empiriq\Contracts\RunnableInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function React\Async\await;
use function React\Promise\all;

#[AsCommand(
    name: 'run',
    description: 'Creates users and stores them in the database',
)]
final class RunCommand extends Command
{
    /**
     * @param LoggerInterface $logger
     * @param iterable<RunnableInterface> $runners
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly iterable $runners,
    ) {
        parent::__construct('run');
    }

    protected function configure(): void
    {
        $this
            ->setHelp(
                <<<'HELP'
                The <info>%command.name%</info> command lists all the users registered in the application:

                  <info>%command.full_name%</info>
                HELP
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $runners = [];
        foreach ($this->runners as $runner) {
            $this->logger->info(sprintf('Running: %s', get_class($runner)));
            $runners[] = $runner->run();
        }

        return max(await(all($runners)));
    }
}
