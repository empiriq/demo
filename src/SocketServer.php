<?php

namespace App;

use Empiriq\Contracts\RunnableInterface;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;
use React\Socket\ConnectionInterface;
use Symfony\Component\Console\Command\Command;

class SocketServer implements RunnableInterface
{
    private \SplObjectStorage $clientConnection;
    private Deferred $deferred;
    private \React\Socket\SocketServer $socketServer;

    public function __construct(
        private readonly TerminalApplication $terminalApplication,
    ) {
    }

    public function run(): PromiseInterface
    {
        $this->clientConnection = new \SplObjectStorage();
        $this->deferred = new Deferred();
        $this->socketServer = new \React\Socket\SocketServer('0.0.0.0:2009', []);
        $this->socketServer->on('connection', [$this, '__connection']);
        $this->socketServer->on('close', [$this, '__close']);
        $this->socketServer->on('error', [$this, '__error']);

        return $this->deferred->promise();
    }

    /**
     * Когда к серверу подключился новый клиент
     * @param ConnectionInterface $connection
     * @return void
     */
    public function __connection(ConnectionInterface $connection): void
    {
        $this->clientConnection->attach(
            new ClientConnection($connection, $this->clientConnection, $this->terminalApplication)
        );
    }

    /**
     * Когда сервер закрыт
     * @param $data
     * @return void
     */
    public function __close($data): void
    {
        $this->deferred->resolve(Command::SUCCESS);
    }

    /**
     * Когда произошла ошибка
     * @param \Throwable $e
     * @return void
     */
    public function __error(\Throwable $e): void
    {
        $this->deferred->resolve(Command::FAILURE);
    }
}
