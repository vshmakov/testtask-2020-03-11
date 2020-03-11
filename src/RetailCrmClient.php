<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class RetailCrmClient
{
    /** @var string */
    private $retailCRMApiKey;

    /** @var string */
    private $retailCRMCompanyName;

    /** @var HttpClientInterface */
    private $client;

    public function __construct(string $retailCRMApiKey, string $retailCRMCompanyName, HttpClientInterface $client)
    {
        $this->retailCRMApiKey = $retailCRMApiKey;
        $this->retailCRMCompanyName = $retailCRMCompanyName;
        $this->client = $client;
    }

    public function request(string $path): array
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            sprintf('https://%s.retailcrm.ru/api/v5%s', $this->retailCRMCompanyName, $path),
            [
                'query' => [
                    'apiKey' => $this->retailCRMApiKey,
                ],
            ]
        );

        return $response->toArray();
    }
}
