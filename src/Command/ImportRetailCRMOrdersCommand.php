<?php

declare(strict_types=1);

namespace App\Command;

use App\RetailCrmClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ImportRetailCRMOrdersCommand extends Command
{
    protected static $defaultName = 'app:order:import';

    /** @var RetailCrmClient */
    private $retailCrmClient;

    public function __construct(string $name = null, RetailCrmClient $retailCrmClient)
    {
        parent::__construct($name);

        $this->retailCrmClient = $retailCrmClient;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->retailCrmClient->request('/orders');

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
