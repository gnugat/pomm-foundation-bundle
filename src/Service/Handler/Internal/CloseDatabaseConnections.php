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

class CloseDatabaseConnections
{
    private const CLOSE_CONNECTIONS = "PGPASSWORD='%password%' psql -U %username% -p %port% -h %host% -w -d %database% -c \"SELECT pg_terminate_backend(pg_stat_activity.pid) FROM pg_stat_activity WHERE pg_stat_activity.datname = '%database%' AND pid <> pg_backend_pid()\"";

    private $executeQuery;

    public function __construct(ExecuteQuery $executeQuery)
    {
        $this->executeQuery = $executeQuery;
    }

    public function close(): void
    {
        $this->executeQuery->execute(self::CLOSE_CONNECTIONS);
    }
}
