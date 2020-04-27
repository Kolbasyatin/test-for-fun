<?php

declare(strict_types=1);


namespace App\Integration;


class HttpDataManager implements DataManagerInterface
{

    private const API_HOST = 'host.example.com';

    private const ENDPOINTS = [
        'lessons' => [
            'endPoint' => '/some/lesson/endpoint'
        ]
    ];
    /**
     * @var DataProviderInterface
     */
    private DataProviderInterface $dataProvider;

    public function __construct(DataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function getData(string $endpoint, string $value): array
    {
        if (!key_exists($endpoint, static::ENDPOINTS)) {
            throw new DataManagerException('There is no endpoint in list');
        }

        $uri = static::ENDPOINTS[$endpoint]['endPoint'];
        $url = sprintf('%s%s', static::API_HOST, $uri);

        return $this->dataProvider->get($url);
    }

}