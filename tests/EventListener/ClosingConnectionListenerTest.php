<?php

/*
 * This file is part of the gnugat/pomm-foundation-bundle package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Gnugat\PommFoundationBundle\EventListener;

use Gnugat\PommFoundationBundle\EventListener\ClosingConnectionListener;
use tests\Gnugat\PommFoundationBundle\App\AppKernel;
use PHPUnit\Framework\TestCase;

class ClosingConnectionListenerTest extends TestCase
{
    private $container;

    protected function setUp(): void
    {
        $kernel = new AppKernel('test', false);
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }

    /**
     * @test
     */
    public function it_has_a_close_connection_listener(): void
    {
        $listeners = $this->container->get('event_dispatcher')->getListeners('kernel.terminate');
        $isCloseConnectionIn = function ($listeners) {
            foreach ($listeners as $listener) {
                if ($listener[0] instanceof ClosingConnectionListener) {
                    return true;
                }
            }

            return false;
        };

        self::assertTrue($isCloseConnectionIn($listeners));
    }
}
