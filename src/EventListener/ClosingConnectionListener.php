<?php

/*
 * This file is part of the gnugat/pomm-foundation-bundle package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\PommFoundationBundle\EventListener;

use Gnugat\PommFoundationBundle\Service\ConnectionQueryManager;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

class ClosingConnectionListener
{
    private $connectionQueryManager;

    public function __construct(ConnectionQueryManager $connectionQueryManager)
    {
        $this->connectionQueryManager = $connectionQueryManager;
    }

    public function onKernelTerminate(TerminateEvent $event): void
    {
        $this->connectionQueryManager->shutdown();
    }
}
