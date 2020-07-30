<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstallCommand extends Command
{
    protected static $defaultName = 'kimai:bundle:demo:install';

    /**
     * @var string
     */
    private $pluginDir;

    public function __construct(string $pluginDir)
    {
        parent::__construct(self::$defaultName);
        $this->pluginDir = $pluginDir;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('Install the demo bundle')
            ->setHelp('This command will install the DemoBundle database.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->importMigrations($io, $output);
        } catch (\Exception $ex) {
            $io->error('Failed to install task management database: ' . $ex->getMessage());

            return 1;
        }

        $io->success(
            'Congratulations! TaskManagement bundle was successful installed!'
        );

        return 0;
    }

    protected function importMigrations(SymfonyStyle $io, OutputInterface $output)
    {
        $config = $this->pluginDir . '/DemoBundle/Migrations/demo.yaml';

        // prevent windows from breaking
        $config = str_replace('/', DIRECTORY_SEPARATOR, $config);

        $command = $this->getApplication()->find('doctrine:migrations:migrate');
        $cmdInput = new ArrayInput(['--allow-no-migration' => true, '--configuration' => $config]);
        $cmdInput->setInteractive(false);
        $command->run($cmdInput, $output);

        $io->writeln('');
    }
}
