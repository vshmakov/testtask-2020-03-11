<?php

declare(strict_types=1);

namespace App;

final class RetailCrmClient
{
    /** @var string */
    private $retailCRMApiKey;

    /** @var string */
    private $retailCRMCompanyName;

    public function __construct(string $retailCRMApiKey, string $retailCRMCompanyName)
    {
        $this->retailCRMApiKey = $retailCRMApiKey;
        $this->retailCRMCompanyName = $retailCRMCompanyName;
    }

    public function request(string $url)
    {
        dd($this->retailCRMApiKey, $this->retailCRMCompanyName);
    }
}
