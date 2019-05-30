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

class CheckDatabaseExistenceHandler
{
    private $checkDatabaseExistence;

    public function __construct(
        CheckDatabaseExistence $checkDatabaseExistence
    ) {
        $this->checkDatabaseExistence = $checkDatabaseExistence;
    }

    public function handle(): bool
    {
        return $this->checkDatabaseExistence->check();
    }
}
