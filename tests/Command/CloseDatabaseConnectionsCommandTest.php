<?php

/*
 * This file is part of the gnugat/pomm-foundation-bundle package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Gnugat\PommFoundationBundle\Command;

use Gnugat\PommFoundationBundle\Command\ExitCode;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;
use tests\Gnugat\PommFoundationBundle\App\AppKernel;

class CloseDatabaseConnectionsCommandTest extends TestCase
{
    private $container;

    protected function setUp(): void
    {
        $kernel = new AppKernel('test', false);
        $kernel->boot();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $this->applicationTester = new ApplicationTester($application);
    }

    /**
     * @test
     */
    public function it_does_nothing_when_database_does_not_exist(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:close-connections',
        ]);
        $output = $this->applicationTester->getDisplay();

        self::assertSame(ExitCode::SUCCESS, $exitCode, $output);
    }

    /**
     * @test
     */
    public function it_closes_database_connections(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:close-connections',
        ]);
        $output = $this->applicationTester->getDisplay();

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(ExitCode::SUCCESS, $exitCode, $output);
    }
}
