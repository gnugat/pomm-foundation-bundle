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

use PommProject\Foundation\Pomm;
use PommProject\Foundation\QueryManager\QueryManagerInterface;

/**
 * A QueryManager tied to a Connection:
 *
 * 1. the first time it is called, opens a new connection
 * 2. the next times it is called, uses the existing connection
 * 3. if shutdown is called, closes the connection and goes back to step 1
 *
 * This allows to keep a 1 to 1 relation between a HTTP request and a database Connection,
 * which is important when the application is a long running process (e.g. tests, FastCGI, AMQP consumer, etc).
 */
class ConnectionQueryManager implements QueryManagerInterface
{
    const NEED_NEW_CONNECTION = 0;
    const CONNECTION_OPENED = 1;

    /**
     * @var Pomm
     */
    private $pomm;

    /**
     * @var QueryManagerInterface
     */
    private $queryManager;

    /**
     * @var int
     */
    private $state;

    /**
     * @param string $host
     * @param string $port
     * @param string $database
     * @param string $username
     * @param string $password
     */
    public function __construct($host, $port, $database, $username, $password)
    {
        $this->pomm = new Pomm(array(
            $database => array(
                'dsn' => "pgsql://$username:$password@$host:$port/$database",
                'class:session_builder' => '\PommProject\Foundation\SessionBuilder',
            ),
        ));
        $this->state = self::NEED_NEW_CONNECTION;
    }

    /**
     * {@inheritdoc}
     */
    public function query($sql, array $parameters = [])
    {
        if (self::NEED_NEW_CONNECTION === $this->state) {
            $this->queryManager = $this->pomm->getDefaultsession()->getQueryManager();
            $this->state = self::CONNECTION_OPENED;
        }

        return $this->queryManager->query($sql, $parameters);
    }

    /**
     * Closes the database connection, should be called after handling a request.
     */
    public function shutdown()
    {
        $this->pomm->shutdown();
        unset($this->queryManager);
        $this->state = self::NEED_NEW_CONNECTION;
    }
}
