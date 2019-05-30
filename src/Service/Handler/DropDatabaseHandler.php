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
use Gnugat\PommFoundationBundle\Service\Handler\Internal\DropDatabase;

class DropDatabaseHandler
{
    private $checkDatabaseExistence;
    private $closeDatabaseConnections;
    private $dropDatabase;

    public function __construct(
        CheckDatabaseExistence $checkDatabaseExistence,
        CloseDatabaseConnections $closeDatabaseConnections,
        DropDatabase $dropDatabase
    ) {
        $this->checkDatabaseExistence = $checkDatabaseExistence;
        $this->closeDatabaseConnections = $closeDatabaseConnections;
        $this->dropDatabase = $dropDatabase;
    }

    public function handle(): void
    {
        if (false === $this->checkDatabaseExistence->check()) {
            return;
        }
        $this->closeDatabaseConnections->close();
        $this->dropDatabase->drop();
    }
}
