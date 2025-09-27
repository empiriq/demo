<?php

namespace App;

use React\Socket\ConnectionInterface;
use Symfony\Component\Console\Output\StreamOutput as SymfonyStreamOutput;

final class StreamOutput extends SymfonyStreamOutput
{
    public function __construct(
        private readonly ConnectionInterface $connection
    ) {
        $stream = fopen('php://temp', 'r+');
        if ($stream === false) {
            throw new \RuntimeException('Failed to open php://temp');
        }
        parent::__construct($stream);
    }

    #[\Override]
    protected function doWrite(string $message, bool $newline): void
    {
        $this->connection->write($message . ($newline ? PHP_EOL : ''));
    }
}
