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
use Gnugat\PommFoundationBundle\Service\Handler\Internal\CreateDatabase;

class CreateDatabaseHandler
{
    private $checkDatabaseExistence;
    private $createDatabase;

    public function __construct(
        CheckDatabaseExistence $checkDatabaseExistence,
        CreateDatabase $createDatabase
    ) {
        $this->checkDatabaseExistence = $checkDatabaseExistence;
        $this->createDatabase = $createDatabase;
    }

    public function handle(): void
    {
        if (true === $this->checkDatabaseExistence->check()) {
            return;
        }
        $this->createDatabase->create();
    }
}
