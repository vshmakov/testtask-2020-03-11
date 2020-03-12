<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Order;
use App\RetailCrmClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class ImportRetailCRMOrdersCommand extends Command
{
    protected static $defaultName = 'app:order:import';

    /** @var RetailCrmClient */
    private $retailCrmClient;

    /** @var DenormalizerInterface */
    private $denormalizer;

    public function __construct(string $name = null, RetailCrmClient $retailCrmClient, DenormalizerInterface $denormalizer)
    {
        parent::__construct($name);

        $this->retailCrmClient = $retailCrmClient;
        $this->denormalizer = $denormalizer;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->getOrdersData() as $data) {
            if (!$data['email']) {
                $data['email'] = null;
            }

            $order = new Order();
            $this->denormalizer->denormalize($data, Order::class, null, [
                AbstractNormalizer::OBJECT_TO_POPULATE => $order,
            ]);
            dd($order);
        }

        $io->success('Orders imported');

        return 0;
    }

    private function getOrdersData(): array
    {
        $orders = [];
        $page = 1;

        do {
            $data = $this->retailCrmClient
                ->request('/orders', [
                    'page' => $page,
                    'limit' => 100,
                ])
                ->toArray();
            $orders = array_merge($orders, $data['orders']);
            ++$page;
        } while ($page <= $data['pagination']['totalPageCount']);

        return $orders;
    }
}
