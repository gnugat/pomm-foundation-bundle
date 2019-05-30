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

class LaunchDatabaseConsole
{
    private const QUERY = "PGPASSWORD='%password%' psql -U %username% -p %port% -h %host% -w -d %database%";

    private $executeQuery;

    public function __construct(ExecuteQuery $executeQuery)
    {
        $this->executeQuery = $executeQuery;
    }

    public function launch(): void
    {
        $this->executeQuery->execute(self::QUERY);
    }
}
