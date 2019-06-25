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

    private $host;
    private $port;
    private $database;
    private $username;
    private $password;

    public function __construct(
        string $host,
        string $port,
        string $database,
        string $username,
        string $password = ''
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
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
            "$query 2>&1"
        ), $output, $exitCode);
        $output = implode("\n", $output);
        if (self::EXIT_SUCCESS !== $exitCode) {
            throw new \RuntimeException($output, $exitCode);
        }

        return $output;
    }
}
