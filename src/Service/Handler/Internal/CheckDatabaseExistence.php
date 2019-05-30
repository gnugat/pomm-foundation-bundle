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

class CheckDatabaseExistence
{
    private const CHECK_EXISTENCE = "PGPASSWORD='%password%' psql -U %username% -p %port% -h %host% -w -lqt | cut -d \| -f 1 | grep -w %database% | wc -l";
    private const DOES_EXISTS = '1';

    private $executeQuery;

    public function __construct(ExecuteQuery $executeQuery)
    {
        $this->executeQuery = $executeQuery;
    }

    public function check(): bool
    {
        $output = $this->executeQuery->execute(self::CHECK_EXISTENCE);

        return self::DOES_EXISTS === $output;
    }
}
