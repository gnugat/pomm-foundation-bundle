<?php

/*
 * This file is part of the gnugat/pomm-foundation-bundle package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Gnugat\PommFoundationBundle;

use PommProject\Foundation\QueryManager\QueryManagerInterface;
use tests\Gnugat\PommFoundationBundle\App\AppKernel;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    private $container;

    protected function setUp()
    {
        $kernel = new AppKernel('test', false);
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }

    /**
     * @test
     */
    public function it_provides_a_legacy_query_manager()
    {
        self::assertInstanceOf(
            QueryManagerInterface::class,
            $this->container->get('gnugat_pomm_foundation.query_manager')
        );
    }

    /**
     * @test
     */
    public function it_provides_a_query_manager()
    {
        self::assertInstanceOf(
            QueryManagerInterface::class,
            $this->container->get(QueryManagerInterface::class)
        );
    }
}
