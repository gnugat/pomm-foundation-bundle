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

class DropDatabase
{
    private const DROP_DATABASE = "PGPASSWORD='%password%' dropdb -U %username% -p %port% -h %host% -w %database% 2>&1";

    private $executeQuery;

    public function __construct(ExecuteQuery $executeQuery)
    {
        $this->executeQuery = $executeQuery;
    }

    public function drop(): void
    {
        $this->executeQuery->execute(self::DROP_DATABASE);
    }
}
