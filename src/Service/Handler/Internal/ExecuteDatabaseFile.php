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

class ExecuteDatabaseFile
{
    private const EXECUTE_FILE = "PGPASSWORD='%password%' psql -U %username% -p %port% -h %host% -w -d %database% -f \"%filename%\"";

    private $executeQuery;

    public function __construct(ExecuteQuery $executeQuery)
    {
        $this->executeQuery = $executeQuery;
    }

    public function execute(string $filename): string
    {
        $output = $this->executeQuery->execute(str_replace(
            '%filename%',
            addslashes($filename),
            self::EXECUTE_FILE
        ));
        if (1 === preg_match('/psql:(.*): ERROR:(.*)/', $output)) {
            throw new \DomainException($output);
        }

        return $output;
    }
}
