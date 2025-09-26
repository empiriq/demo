<?php

namespace App;

use React\Socket\ConnectionInterface;
use Symfony\Component\Console\Output\StreamOutput as SymfonyStreamOutput;

class StreamOutput extends SymfonyStreamOutput
{
    public function __construct(
        private readonly ConnectionInterface $connection
    ) {
        parent::__construct(fopen('php://temp', 'r+'));
    }

    protected function doWrite(string $message, bool $newline): void
    {
        $this->connection->write($message . ($newline ? PHP_EOL : ''));
    }
}
