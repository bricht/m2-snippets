<?php
declare(strict_types=1);

namespace Als\RunCron\Cron;

use Psr\Log\LoggerInterface;

class RunTheCron
{

    /**
     * @var LoggerInterface
     */
    private $_logger;

    /**
     * CheckApiStatus constructor.
     * @param LoggerInterface $_logger
     */
    public function __construct(
        LoggerInterface $_logger
    ) {
        $this->_logger      = $_logger;
    }

    /**
     * Run cron command.
     */
    public function execute()
    {
        $this->_logger->info('Cron Command RAN.');
        $this->_logger->info('Cron Command RAN.');
        $this->_logger->info('Cron Command RAN.');
    }
}
