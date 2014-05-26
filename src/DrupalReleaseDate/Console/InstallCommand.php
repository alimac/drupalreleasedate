<?php
namespace DrupalReleaseDate\Console;

use DrupalReleaseDate\Installation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('install')
            ->setDescription('Run system installation');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $installation = new Installation($this->getApplication()->getContainer());
        $installation->install();
        $output->writeln('Install Complete');
    }
}
