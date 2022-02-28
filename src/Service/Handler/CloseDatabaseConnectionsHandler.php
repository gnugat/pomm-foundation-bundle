<?php

/*
 * This file is part of the gnugat/pomm-foundation-bundle package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\PommFoundationBundle\Service\Handler;

use Gnugat\PommFoundationBundle\Service\Handler\Internal\CheckDatabaseExistence;
use Gnugat\PommFoundationBundle\Service\Handler\Internal\CloseDatabaseConnections;

class CloseDatabaseConnectionsHandler
{
    public function __construct(
        private CheckDatabaseExistence $checkDatabaseExistence,
        private CloseDatabaseConnections $closeDatabaseConnections,
    ) {
    }

    public function handle(): void
    {
        if (false === $this->checkDatabaseExistence->check()) {
            return;
        }
        $this->closeDatabaseConnections->close();
    }
}
