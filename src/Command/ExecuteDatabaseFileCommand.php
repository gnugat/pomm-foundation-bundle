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

use Gnugat\PommFoundationBundle\Service\Handler\ExecuteDatabaseFileHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecuteDatabaseFileCommand extends Command
{
    private const HELP = <<<'TEXT'
Also allows restoring a database using a dump file:

    bin/console gnugat-pomm-foundation:database:dump > /tmp/dump.sql
    bin/console gnugat-pomm-foundation:database:drop
    bin/console gnugat-pomm-foundation:database:create
    bin/console gnugat-pomm-foundation:database:execute-file /tmp/dump.sql
TEXT;

    public function __construct(
        private ExecuteDatabaseFileHandler $executeDatabaseFileHandler
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('gnugat-pomm-foundation:database:execute-file')
            ->setDescription('Executes the database file')
            ->setHelp(self::HELP)
            ->addArgument('filename', InputArgument::REQUIRED)
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
            $results = $this->executeDatabaseFileHandler->handle(
                $input->getArgument('filename')
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
