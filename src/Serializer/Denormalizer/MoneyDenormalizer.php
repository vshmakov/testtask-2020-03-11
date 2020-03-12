<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use Money\Money;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class MoneyDenormalizer implements DenormalizerInterface
{
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return Money::class === $type;
    }

    public function denormalize($amount, string $type, string $format = null, array $context = []): Money
    {
        return Money::RUB($amount * 100);
    }
}
