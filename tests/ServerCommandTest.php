<?php

namespace App\Tests;

use App\RunCommand;
use Empiriq\Contracts\EnvironmentInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Tester\CommandTester;

final class ServerCommandTest extends TestCase
{
    public function testExecuteRunsEnvironmentAndLogs(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $environment = $this->createMock(EnvironmentInterface::class);

        // ожидаем, что среда будет запущена
        $environment->expects(self::once())
            ->method('run');

        // ожидаем, что логгер пишет debug с нужным env
        $logger->expects(self::once())
            ->method('debug')
            ->with(self::stringContains('Running in environment: backtrade'));

        // error тоже будет вызван
        $logger->expects(self::once())
            ->method('error')
            ->with('asdda');

        $command = new RunCommand($logger, [$environment]);

        $tester = new CommandTester($command);
        $exitCode = $tester->execute([
            'environment' => 'backtrade',
        ]);

        $this->assertSame(0, $exitCode, 'Команда должна завершиться успешно');
    }
}
