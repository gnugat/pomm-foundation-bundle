<?php

/*
 * This file is part of the gnugat/pomm-foundation-bundle package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\PommFoundationBundle\Service\Handler\Internal;

class ExecuteQuery
{
    private const EXIT_SUCCESS = 0;

    public function __construct(
        private string $host,
        private string $port,
        private string $database,
        private string $username,
        private string $password = '',
    ) {
    }

    public function execute(string $query): string
    {
        exec(str_replace(
            [
                '%host%',
                '%port%',
                '%database%',
                '%username%',
                '%password%',
            ],
            [
                $this->host,
                $this->port,
                $this->database,
                $this->username,
                $this->password,
            ],
            "{$query} 2>&1",
        ), $output, $exitCode);
        $output = implode("\n", $output);
        if (self::EXIT_SUCCESS !== $exitCode) {
            throw new \RuntimeException($output, $exitCode);
        }

        return $output;
    }
}
