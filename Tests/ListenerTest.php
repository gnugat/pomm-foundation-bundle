<?php

/*
 * This file is part of the gnugat/pomm-foundation-bundle package.
 *
 * (c) Loïc Faugeron <faugeron.loic+pomm-foundation-bundle@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\PommFoundationBundle\Tests;

use Gnugat\PommFoundationBundle\EventListener\ClosingConnectionListener;
use PHPUnit_Framework_TestCase;

class ListenerTest extends PHPUnit_Framework_TestCase
{
    private $container;

    protected function setUp()
    {
        $kernel = new \AppKernel('test', false);
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }

    /**
     * @test
     */
    public function it_has_a_close_connection_listener()
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
