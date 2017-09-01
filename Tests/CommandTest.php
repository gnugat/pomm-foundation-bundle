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

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    private $container;

    protected function setUp()
    {
        $kernel = new \AppKernel('test', false);
        $kernel->boot();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $this->applicationTester = new ApplicationTester($application);
    }

    /**
     * @test
     */
    public function it_has_create_database_command()
    {
        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $this->assertSame(0, $exitCode, $this->applicationTester->getDisplay());
    }

    /**
     * @test
     */
    public function it_has_drop_database_command()
    {
        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        $this->assertSame(0, $exitCode, $this->applicationTester->getDisplay());
    }
}
