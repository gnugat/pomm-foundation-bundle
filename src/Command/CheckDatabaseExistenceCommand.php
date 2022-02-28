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

use Gnugat\PommFoundationBundle\Service\Handler\CheckDatabaseExistenceHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckDatabaseExistenceCommand extends Command
{
    public function __construct(
        private CheckDatabaseExistenceHandler $checkDatabaseExistenceHandler
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('gnugat-pomm-foundation:database:check-existence')
            ->setDescription('Creates the database')
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
        $output->writeln('// Checking the database\'s existence');
        $output->writeln('');

        $doesExist = $this->checkDatabaseExistenceHandler->handle();

        $output->writeln(
            'The database does'.($doesExist ? '' : ' not').' exist'
        );
        $output->writeln('');

        $output->writeln(' [OK] Database existence checked');
        $output->writeln('');

        return ExitCode::SUCCESS;
    }
}
