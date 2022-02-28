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

use Gnugat\PommFoundationBundle\Service\Handler\CloseDatabaseConnectionsHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CloseDatabaseConnectionsCommand extends Command
{
    public function __construct(
        private CloseDatabaseConnectionsHandler $closeDatabaseConnectionsHandler
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('gnugat-pomm-foundation:database:close-connections')
            ->setDescription('Closes the database connections')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $output->writeln('');
        $output->writeln('// Closing the database connections');
        $output->writeln('');

        $this->closeDatabaseConnectionsHandler->handle();

        $output->writeln(' [OK] Database connections closed');
        $output->writeln('');

        return ExitCode::SUCCESS;
    }
}
