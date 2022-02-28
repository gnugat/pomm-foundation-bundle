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

class QueryDatabase
{
    private const QUERY = "PGPASSWORD='%password%' psql -U %username% -p %port% -h %host% -w -d %database% -c \"%sql%\"";

    public function __construct(
        private ExecuteQuery $executeQuery
    ) {
    }

    public function query(string $sql): string
    {
        return $this->executeQuery->execute(str_replace(
            '%sql%',
            addslashes($sql),
            self::QUERY
        ));
    }
}
