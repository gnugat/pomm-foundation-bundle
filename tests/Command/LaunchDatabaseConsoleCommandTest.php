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

class LaunchDatabaseConsoleCommandTest extends TestCase
{
    private const NON_EXISTING_DATABASE = <<<'OUTPUT'

         [ERROR] The database does not exist


        OUTPUT;

    private ApplicationTester $applicationTester;

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
    public function it_cannot_launch_console_for_non_existing_database(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:launch',
        ]);
        $output = $this->applicationTester->getDisplay();

        self::assertSame(self::NON_EXISTING_DATABASE, $output);
        self::assertSame(ExitCode::ERROR, $exitCode);
    }
}
