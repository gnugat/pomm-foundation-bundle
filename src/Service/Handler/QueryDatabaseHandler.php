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
use Gnugat\PommFoundationBundle\Service\Handler\Internal\QueryDatabase;

class QueryDatabaseHandler
{
    private $checkDatabaseExistence;
    private $queryDatabase;

    public function __construct(
        CheckDatabaseExistence $checkDatabaseExistence,
        QueryDatabase $queryDatabase
    ) {
        $this->checkDatabaseExistence = $checkDatabaseExistence;
        $this->queryDatabase = $queryDatabase;
    }

    public function handle(string $sql): string
    {
        if (false === $this->checkDatabaseExistence->check()) {
            throw new \DomainException('The database does not exist');
        }

        try {
            return $this->queryDatabase->query($sql);
        } catch (\RuntimeException $e) {
            throw new \DomainException($e->getMessage(), $e->getCode());
        }
    }
}
