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

class DumpDatabaseCommandTest extends TestCase
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
    public function it_cannot_dump_non_existing_database(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:dump',
        ]);
        $output = $this->applicationTester->getDisplay();

        self::assertSame(self::NON_EXISTING_DATABASE, $output);
        self::assertSame(ExitCode::ERROR, $exitCode);
    }

    /**
     * @test
     */
    public function it_dumps_database(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:query',
            'sql' => 'CREATE TABLE my_table();',
        ]);

        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:dump',
        ]);
        $output = $this->applicationTester->getDisplay();

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertTrue(1 === preg_match(
            '/PostgreSQL database dump/',
            $output,
        ), $output);
        self::assertTrue(1 === preg_match(
            '/CREATE TABLE public.my_table/',
            $output,
        ), $output);
        self::assertSame(ExitCode::SUCCESS, $exitCode);
    }
}
