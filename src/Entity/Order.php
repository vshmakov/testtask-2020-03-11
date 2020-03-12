<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Money\Money;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @var string|null
     * @ORM\Column
     */
    private $status;

    /**
     * @var Money|null
     * @ORM\Column(type="rub")
     */
    private $totalSumm;

    /**
     * @var string|null
     * @ORM\Column
     */
    private $firstName;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     */
    private $email;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     */
    private $comment;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     */
    private $site;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getTotalSumm(): ?Money
    {
        return $this->totalSumm;
    }

    public function setTotalSumm(?Money $totalSumm): void
    {
        $this->totalSumm = $totalSumm;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): void
    {
        $this->site = $site;
    }
}
