<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

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

    public function request(string $method, string $path, array $parameters): ResponseInterface
    {
        $query = Request::METHOD_GET === $method ? $parameters : [];
        $body = Request::METHOD_POST === $method ? $parameters : [];

        return $this->client->request(
            $method,
            sprintf('https://%s.retailcrm.ru/api/v5%s', $this->retailCRMCompanyName, $path),
            [
                'query' => $query + [
                        'apiKey' => $this->retailCRMApiKey,
                    ],
                'body' => $body,
            ]
        );
    }
}
