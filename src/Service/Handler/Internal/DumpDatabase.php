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

class DumpDatabase
{
    private const DUMP_DATABASE = "PGPASSWORD='%password%' pg_dump -U %username% -p %port% -h %host% -w -Fp -x %database%";

    public function __construct(
        private ExecuteQuery $executeQuery,
    ) {
    }

    public function dump(): string
    {
        return $this->executeQuery->execute(self::DUMP_DATABASE);
    }
}
