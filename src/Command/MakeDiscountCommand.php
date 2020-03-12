<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Order;
use App\RetailCrmClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class MakeDiscountCommand extends Command
{
    protected static $defaultName = 'app:order:discount';

    /** @var RetailCrmClient */
    private $retailCrmClient;

    /** @var DenormalizerInterface */
    private $denormalizer;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(string $name = null, RetailCrmClient $retailCrmClient, DenormalizerInterface $denormalizer, EntityManagerInterface $entityManager)
    {
        parent::__construct($name);

        $this->retailCrmClient = $retailCrmClient;
        $this->denormalizer = $denormalizer;
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var Order[] $orders */
        $orders = $this->entityManager
            ->getRepository(Order::class)
            ->findAll();

        foreach ($orders as $order) {
            if ($this->isDiscountable($order)) {
                $order->setTotalSumm(
                    $order->getTotalSumm()
                        ->multiply(0.9)
                );
                $order->setComment('Сделали скидку в 10%');
            }
        }

        $this->entityManager->flush();
        $io->success('Made  the discount');

        return 0;
    }

    private function isDiscountable(Order $order): bool
    {
        return null !== $order->getEmail() && preg_match('#@gmail.com$#', $order->getEmail());
    }
}
