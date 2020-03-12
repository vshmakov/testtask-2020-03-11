<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;
use Money\Money;

final class RubType extends IntegerType
{
    public function getName(): string
    {
        return 'rub';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $amount = parent::convertToPHPValue($value, $platform);

        if (null === $amount) {
            return null;
        }

        return Money::RUB($amount);
    }

    /**
     * @param Money $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (int) $value->getAmount();
    }
}
