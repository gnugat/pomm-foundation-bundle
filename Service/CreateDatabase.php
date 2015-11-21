<?php

/*
 * This file is part of the gnugat/pomm-foundation-bundle package.
 *
 * (c) Loïc Faugeron <faugeron.loic+pomm-foundation-bundle@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\PommFoundationBundle\Service;

class CreateDatabase
{
    const EXIT_SUCCESS = 0;
    const DATABASE_ALREADY_EXISTS = '1';

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $port;

    /**
     * @var string
     */
    private $database;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $host
     * @param string $port
     * @param string $database
     * @param string $username
     * @param string $password
     */
    public function __construct($host, $port, $database, $username, $password = null)
    {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function create()
    {
        $command = 'psql';
        $connectionOptions = "-h {$this->host} -p {$this->port} -U {$this->username}";
        if (null !== $this->password) {
            $command = "PGPASSWORD={$this->password} $command";
        } else {
            $connectionOptions .= ' -w';
        }
        exec("$command $connectionOptions -lqt | cut -d \| -f 1 | grep -w {$this->database} | wc -l", $output);
        if (self::DATABASE_ALREADY_EXISTS === $output[0]) {
            return;
        }
        exec("$command -c 'CREATE DATABASE {$this->database};' $connectionOptions 2>&1", $output, $exitCode);
        if (self::EXIT_SUCCESS !== $exitCode) {
            throw new \RuntimeException(implode("\n", $output), $exitCode);
        }
    }
}
