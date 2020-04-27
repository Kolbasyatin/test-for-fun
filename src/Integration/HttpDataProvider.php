<?php

declare(strict_types=1);


namespace App\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class DataProvider
 * @package App\Integration
 */
class HttpDataProvider implements DataProviderInterface
{
    private $host;
    private $userName;
    private $password;

    /**
     * @var Client
     */
    private $guzzle;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->host = $options['host'];
        $this->userName = $options['userName'];
        $this->password = $options['password'];
        $this->guzzle = new Client();
    }

    public function get(string $url, ?array $query = null): array
    {
        try {
            $response = $this->guzzle->request(
                'GET',
                $url,
                [
                    'auth' => [$this->userName, $this->password],
                    'query' => $query
                ],

            );
            $json = json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            $message = sprintf('There is error in %s. Original error message %s', __METHOD__, $e->getMessage());
            throw new DataManagerException($message);
        }

        return json_decode($json, JSON_UNESCAPED_UNICODE);
    }
}