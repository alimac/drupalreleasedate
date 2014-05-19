<?php
namespace DrupalReleaseDate\Console;

use DrupalReleaseDate\Installation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends Command
{
    /**
     *
     * @var \DrupalReleaseDate\Installation
     */
    protected $installation;

    /**
     * @param \DrupalReleaseDate\Installation
     */
    public function __construct(Installation $installation)
    {
        $this->installation = $installation;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('update')
            ->setDescription('Run system updates');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->installation->update();
        $output->writeln('Update Complete');
    }
}
