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
use Gnugat\PommFoundationBundle\Service\Handler\Internal\DumpDatabase;

class DumpDatabaseHandler
{
    private $checkDatabaseExistence;
    private $dumpDatabase;

    public function __construct(
        CheckDatabaseExistence $checkDatabaseExistence,
        DumpDatabase $dumpDatabase
    ) {
        $this->checkDatabaseExistence = $checkDatabaseExistence;
        $this->dumpDatabase = $dumpDatabase;
    }

    public function handle(): string
    {
        if (false === $this->checkDatabaseExistence->check()) {
            throw new \DomainException('The database does not exist');
        }

        return $this->dumpDatabase->dump();
    }
}
