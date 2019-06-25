<?php

/*
 * This file is part of the gnugat/pomm-foundation-bundle package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Gnugat\PommFoundationBundle\Service;

use Gnugat\PommFoundationBundle\Service\ConnectionQueryManager;
use PHPUnit\Framework\TestCase;
use PommProject\Foundation\QueryManager\QueryManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;
use tests\Gnugat\PommFoundationBundle\App\AppKernel;

class ConnectionQueryManagerTest extends TestCase
{
    private const CREATE_MY_EMPTY_TABLE = 'CREATE TABLE my_empty_table ()';
    private const CREATE_MY_BOOLEAN_TABLE = <<<'SQL'
CREATE TABLE my_boolean_table (my_boolean BOOLEAN)
SQL
    ;
    private const CREATE_MY_TIMESTAMP_TABLE = <<<'SQL'
CREATE TABLE my_timestamp_table (my_timestamp TIMESTAMP)
SQL
    ;

    private const INSERT_INTO_MY_BOOLEAN_TABLE = <<<'SQL'
INSERT INTO my_boolean_table (my_boolean)
VALUES ($*)
SQL
    ;
    private const INSERT_INTO_MY_TIMESTAMP_TABLE = <<<'SQL'
INSERT INTO my_timestamp_table (my_timestamp)
VALUES ($*)
SQL
    ;

    private const SELECT_MY_EMPTY_TABLE = 'SELECT * FROM my_empty_table';
    private const COUNT_MY_EMPTY_TABLE = <<<'SQL'
SELECT COUNT(*) AS my_count
FROM my_empty_table
SQL
    ;
    private const SELECT_MY_BOOLEAN_TABLE = 'SELECT * FROM my_boolean_table';
    private const SELECT_MY_TIMESTAMP_TABLE = 'SELECT * FROM my_timestamp_table';

    private const MY_LITERAL_FALSE_BOOLEAN = 'f';
    private const MY_FALSE_BOOLEAN = false;
    private const MY_FALSISH_BOOLEAN = 0;
    private const MY_LITERAL_TRUE_BOOLEAN = 't';
    private const MY_TRUE_BOOLEAN = true;
    private const MY_TRUISH_BOOLEAN = 1;
    private const MY_TIMESTAMP = '2019-06-24 11:42:23 UTC';

    private const MY_EMPTY_RESULTS = [];
    private const MY_EMPTY_COUNT = 0;
    private const MY_BOOLEAN_RESULTS = [
        ['my_boolean' => self::MY_FALSE_BOOLEAN],
        ['my_boolean' => self::MY_TRUE_BOOLEAN],
    ];

    private $applicationTester;
    private $queryManager;

    protected function setUp(): void
    {
        $kernel = new AppKernel('test', false);
        $kernel->boot();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $this->applicationTester = new ApplicationTester($application);
        $this->queryManager = $kernel->getContainer()->get(
            QueryManagerInterface::class
        );
    }

    /**
     * @test
     */
    public function it_can_query(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $this->queryManager->query(self::CREATE_MY_EMPTY_TABLE);
        $results = iterator_to_array($this->queryManager->query(
            self::SELECT_MY_EMPTY_TABLE
        ));
        $count = $this->queryManager->query(
            self::COUNT_MY_EMPTY_TABLE
        )->current()['my_count'];

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(self::MY_EMPTY_RESULTS, $results);
        self::assertSame(self::MY_EMPTY_COUNT, $count);
    }

    /**
     * @test
     */
    public function it_can_use_literal_boolean_parameters(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $this->queryManager->query(self::CREATE_MY_BOOLEAN_TABLE);
        $this->queryManager->query(self::INSERT_INTO_MY_BOOLEAN_TABLE, [
            self::MY_LITERAL_FALSE_BOOLEAN,
        ]);
        $this->queryManager->query(self::INSERT_INTO_MY_BOOLEAN_TABLE, [
            self::MY_LITERAL_TRUE_BOOLEAN,
        ]);
        $results = $this->queryManager->query(self::SELECT_MY_BOOLEAN_TABLE);

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(
            self::MY_BOOLEAN_RESULTS,
            iterator_to_array($results)
        );
    }

    /**
     * @test
     */
    public function it_can_use_boolean_parameters(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $this->queryManager->query(self::CREATE_MY_BOOLEAN_TABLE);
        $this->queryManager->query(self::INSERT_INTO_MY_BOOLEAN_TABLE, [
            self::MY_FALSE_BOOLEAN,
        ]);
        $this->queryManager->query(self::INSERT_INTO_MY_BOOLEAN_TABLE, [
            self::MY_TRUE_BOOLEAN,
        ]);
        $results = $this->queryManager->query(self::SELECT_MY_BOOLEAN_TABLE);

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(
            self::MY_BOOLEAN_RESULTS,
            iterator_to_array($results)
        );
    }

    /**
     * @test
     */
    public function it_cannot_use_booleanish_parameters(): void
    {
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $this->queryManager->query(self::CREATE_MY_BOOLEAN_TABLE);
        $this->queryManager->query(self::INSERT_INTO_MY_BOOLEAN_TABLE, [
            self::MY_FALSISH_BOOLEAN,
        ]);
        $this->queryManager->query(self::INSERT_INTO_MY_BOOLEAN_TABLE, [
            self::MY_TRUISH_BOOLEAN,
        ]);
        $results = $this->queryManager->query(self::SELECT_MY_BOOLEAN_TABLE);

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(
            self::MY_BOOLEAN_RESULTS,
            iterator_to_array($results)
        );
    }

    /**
     * @test
     */
    public function it_can_use_literal_timestamp_parameters(): void
    {
        date_default_timezone_set('UTC');
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $this->queryManager->query(self::CREATE_MY_TIMESTAMP_TABLE);
        $this->queryManager->query(self::INSERT_INTO_MY_TIMESTAMP_TABLE, [
            self::MY_TIMESTAMP,
        ]);
        $timestampResult = $this->queryManager->query(
            self::SELECT_MY_TIMESTAMP_TABLE
        )->current()['my_timestamp']->format(
            ConnectionQueryManager::TIMESTAMP_FORMAT
        );

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(self::MY_TIMESTAMP, $timestampResult);
    }

    /**
     * @test
     */
    public function it_can_use_date_time_timestamp_parameters(): void
    {
        date_default_timezone_set('UTC');
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);
        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:create',
        ]);

        $this->queryManager->query(self::CREATE_MY_TIMESTAMP_TABLE);
        $this->queryManager->query(self::INSERT_INTO_MY_TIMESTAMP_TABLE, [
            \DateTime::createFromFormat(
                ConnectionQueryManager::TIMESTAMP_FORMAT,
                self::MY_TIMESTAMP
            ),
        ]);
        $timestampResult = $this->queryManager->query(
            self::SELECT_MY_TIMESTAMP_TABLE
        )->current()['my_timestamp']->format(
            ConnectionQueryManager::TIMESTAMP_FORMAT
        );

        $this->applicationTester->run([
            'gnugat-pomm-foundation:database:drop',
        ]);

        self::assertSame(self::MY_TIMESTAMP, $timestampResult);
    }
}
