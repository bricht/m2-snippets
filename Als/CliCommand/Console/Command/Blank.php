<?php
declare(strict_types=1);

namespace Als\CliCommand\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Console\Cli;
//here

class Blank extends Command
{
    /** @var State */
    protected $state;

    /**
     * TestCheck constructor.
     * @param State $state
     */
    public function __construct(
        State $state
        //here
    ) {
        $this->state = $state;
        //here
        parent::__construct();
    }


    protected function configure()
    {
        $this->setName('als:run:blank')->setDescription('Setup DB');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Testing Blank.</info>');
        $this->state->setAreaCode(Area::AREA_CRONTAB);

        //here
        $output->writeln('<info>Testing Blank finished.</info>');
        return Cli::RETURN_SUCCESS;
    }
}
