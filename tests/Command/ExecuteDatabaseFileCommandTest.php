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

class ExecuteDatabaseFileCommandTest extends TestCase
{
    private const SUCCESSFUL_FILE = __DIR__.'/fixtures/successful_file.sql';
    private const DUMP_FILE = __DIR__.'/fixtures/dump_file.sql';
    private const WRONG_QUERY_FILE = __DIR__.'/fixtures/wrong_query_file.sql';
    private const WRONG_SYNTAX_FILE = __DIR__.'/fixtures/wrong_syntax_file.sql';
    private const NON_EXISTING_FILE = __DIR__.'/fixtures/non_existing_file.sql';

    private const NON_EXISTING_DATABASE = <<<'OUTPUT'

         [ERROR] The database does not exist


        OUTPUT;
    private const FILE_EXECUTED = <<<'OUTPUT'
        CREATE TABLE
         count
        -------
             0
        (1 row)


        OUTPUT;
    private const DUMP_FILE_RESTORED = <<<'OUTPUT'
        SET
        SET
        SET
        SET
        SET
         set_config
        ------------

        (1 row)

        SET
        SET
        SET
        SET
        CREATE EXTENSION
        COMMENT

        OUTPUT;
    private const WRONG_QUERY_FILE_ERROR = <<<'OUTPUT'

         [ERROR] psql:%filename%:1: ERROR:  relation "my_table" does not exist
        LINE 1: SELECT COUNT(*) FROM my_table;
                                     ^


        OUTPUT;
    private const WRONG_SYNTAX_FILE_ERROR = <<<'OUTPUT'

         [ERROR] psql:%filename%:3: ERROR:  syntax error at or near "<?"
        LINE 1: <?php
                ^


        OUTPUT;
    private const NON_EXISTING_FILE_ERROR = <<<'OUTPUT'

         [ERROR] %filename%: No such file or directory


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
    public function it_cannot_query_non_existing_database(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:execute-file',
            'filename' => self::SUCCESSFUL_FILE,
        ]);
        $output = $this->applicationTester->getDisplay();

        self::assertSame(self::NON_EXISTING_DATABASE, $output);
        self::assertSame(ExitCode::ERROR, $exitCode);
    }

    /**
     * @test
     */
    public function it_executes_database_file(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:execute-file',
            'filename' => self::SUCCESSFUL_FILE,
        ]);
        $output = $this->applicationTester->getDisplay();

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(self::FILE_EXECUTED, $output);
        self::assertSame(ExitCode::SUCCESS, $exitCode);
    }

    /**
     * @test
     */
    public function it_can_restore_database_from_dump_file(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:dump',
        ]);
        $dump = $this->applicationTester->getDisplay();
        file_put_contents(self::DUMP_FILE, $dump);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:execute-file',
            'filename' => self::DUMP_FILE,
        ]);
        $output = $this->applicationTester->getDisplay();

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(self::DUMP_FILE_RESTORED, $output);
        self::assertSame(ExitCode::SUCCESS, $exitCode);
    }

    /**
     * @test
     */
    public function it_cannot_execute_query_errors(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:execute-file',
            'filename' => self::WRONG_QUERY_FILE,
        ]);
        $output = $this->applicationTester->getDisplay();

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(
            str_replace(
                '%filename%',
                self::WRONG_QUERY_FILE,
                self::WRONG_QUERY_FILE_ERROR,
            ),
            $output,
        );
        self::assertSame(ExitCode::ERROR, $exitCode);
    }

    /**
     * @test
     */
    public function it_cannot_execute_syntax_errors(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:execute-file',
            'filename' => self::WRONG_SYNTAX_FILE,
        ]);
        $output = $this->applicationTester->getDisplay();

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(
            str_replace(
                '%filename%',
                self::WRONG_SYNTAX_FILE,
                self::WRONG_SYNTAX_FILE_ERROR,
            ),
            $output,
        );
        self::assertSame(ExitCode::ERROR, $exitCode);
    }

    /**
     * @test
     */
    public function it_cannot_execute_non_existing_files(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $exitCode = $this->applicationTester->run([
            'gnugat-pomm-foundation:database:execute-file',
            'filename' => self::NON_EXISTING_FILE,
        ]);
        $output = $this->applicationTester->getDisplay();

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(
            str_replace(
                '%filename%',
                self::NON_EXISTING_FILE,
                self::NON_EXISTING_FILE_ERROR,
            ),
            $output,
        );
        self::assertSame(ExitCode::ERROR, $exitCode);
    }
}
