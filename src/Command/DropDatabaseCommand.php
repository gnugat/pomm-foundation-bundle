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

use Gnugat\PommFoundationBundle\Service\Handler\DropDatabaseHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DropDatabaseCommand extends Command
{
    public function __construct(
        private DropDatabaseHandler $dropDatabaseHandler,
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('gnugat-pomm-foundation:database:drop')
            ->setDescription('Drops the database');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output,
    ): int {
        $output->writeln('');
        $output->writeln('// Dropping the database');
        $output->writeln('');

        $this->dropDatabaseHandler->handle();

        $output->writeln(' [OK] Database dropped');
        $output->writeln('');

        return ExitCode::SUCCESS;
    }
}
