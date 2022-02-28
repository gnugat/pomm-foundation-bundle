<?php

/*
 * This file is part of the gnugat/pomm-foundation-bundle package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\PommFoundationBundle\Service;

use PommProject\Foundation\Pomm;
use PommProject\Foundation\QueryManager\QueryManagerInterface;

/**
 * A QueryManager tied to a Connection:.
 *
 * 1. the first time it is called, opens a new connection
 * 2. the next times it is called, uses the existing connection
 * 3. if shutdown is called, closes the connection and goes back to step 1
 *
 * This allows to keep a 1 to 1 relation between a HTTP request and a database
 * Connection, which is important when the application is a long running process
 * (e.g. tests, FastCGI, AMQP consumer, etc).
 *
 * Also makes sure boolean parameters are converted to 't' and 'f',
 * as Pomm Foundation doesn't support it out of the box.
 */
class ConnectionQueryManager implements QueryManagerInterface
{
    public const TIMESTAMP_FORMAT = 'Y-m-d H:i:s T';
    private const NEED_NEW_CONNECTION = 0;
    private const CONNECTION_OPENED = 1;

    private $pomm;
    private $queryManager;
    private $state = self::NEED_NEW_CONNECTION;

    public function __construct(
        string $host,
        string $port,
        string $database,
        string $username,
        string $password,
    ) {
        $this->pomm = new Pomm([
            $database => [
                'dsn' => "pgsql://{$username}:{$password}@{$host}:{$port}/{$database}",
                'class:session_builder' => '\PommProject\Foundation\SessionBuilder',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function query($sql, array $parameters = [])
    {
        foreach ($parameters as $index => $parameter) {
            if (true === is_bool($parameter)) {
                $parameters[$index] = $parameter ? 't' : 'f';

                continue;
            }
            if ($parameter instanceof \DateTime) {
                $parameters[$index] = $parameter->format(
                    self::TIMESTAMP_FORMAT,
                );

                continue;
            }
        }
        if (self::NEED_NEW_CONNECTION === $this->state) {
            $this->queryManager = $this->pomm->getDefaultsession()->getQueryManager();
            $this->state = self::CONNECTION_OPENED;
        }

        return $this->queryManager->query($sql, $parameters);
    }

    /**
     * Closes the database connection, should be called after handling a request.
     */
    public function shutdown(): void
    {
        $this->pomm->shutdown();
        $this->queryManager = null;
        $this->state = self::NEED_NEW_CONNECTION;
    }
}
