<?php

/*
 * This file is part of the gnugat/pomm-foundation-bundle package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\PommFoundationBundle\Command;

use Gnugat\PommFoundationBundle\Service\Handler\QueryDatabaseHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueryDatabaseCommand extends Command
{
    public function __construct(
        private QueryDatabaseHandler $queryDatabaseHandler
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('gnugat-pomm-foundation:database:query')
            ->setDescription('Queries the database')
            ->addArgument('sql', InputArgument::REQUIRED)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        try {
            $results = $this->queryDatabaseHandler->handle(
                $input->getArgument('sql')
            );

            $output->writeln($results);

            return ExitCode::SUCCESS;
        } catch (\DomainException $e) {
            $output->writeln('');
            $output->writeln(' [ERROR] '.$e->getMessage());
            $output->writeln('');

            return ExitCode::ERROR;
        }
    }
}
