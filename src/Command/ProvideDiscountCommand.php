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
use Symfony\Component\HttpFoundation\Request;

final class ProvideDiscountCommand extends Command
{
    private const  DISCOUNT_PERCENT = 10;

    protected static $defaultName = 'app:order:discount';

    /** @var RetailCrmClient */
    private $retailCrmClient;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(string $name = null, RetailCrmClient $retailCrmClient, EntityManagerInterface $entityManager)
    {
        parent::__construct($name);

        $this->retailCrmClient = $retailCrmClient;
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
                        ->multiply(1 - self::DISCOUNT_PERCENT / 100)
                );
                $order->setComment(sprintf('Сделали скидку в %s', self::DISCOUNT_PERCENT.'%'));
                $this->retailCrmClient->request(
                    Request::METHOD_POST,
                    sprintf('/orders/%s/edit', $order->getId()),
                    [
                        'by' => 'id',
                        'site' => $order->getSite(),
                        'order' => json_encode([
                            'discountManualPercent' => self::DISCOUNT_PERCENT,
                        ]),
                    ]
                );
                $this->entityManager->flush();
            }
        }

        $io->success('Provided a discount');

        return 0;
    }

    private function isDiscountable(Order $order): bool
    {
        return null !== $order->getEmail() && preg_match('#@gmail.com$#', $order->getEmail());
    }
}
