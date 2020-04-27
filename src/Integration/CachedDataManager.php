<?php

declare(strict_types=1);


namespace App\Integration;


use DateTime;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

/**
 * Class CachedDataManager
 * @package App\Integration
 */
class CachedDataManager implements DataManagerInterface
{
    /**
     * @var DataManagerInterface
     */
    private DataManagerInterface $dataManager;

    /** @var  CacheItemPoolInterface */
    private $cache;

    /**
     * CachedDataManager constructor.
     * @param DataManagerInterface $dataManager
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(DataManagerInterface $dataManager, CacheItemPoolInterface $cache)
    {
        $this->dataManager = $dataManager;
        $this->cache = $cache;
    }

    /**
     * @param string $endpoint
     * @param string $value
     * @return array
     * @throws DataManagerException
     */
    public function getData(string $endpoint, string $value): array
    {
        $cache_key = sprintf('%s_category_%s', $endpoint, $value);

        try {
            $cacheItem = $this->cache->getItem($cache_key);
        } catch (InvalidArgumentException $e) {
            throw new DataManagerException($e);
        }

        if ($cacheItem->isHit() && null !== $result = $cacheItem->get()) {
            return $result;
        }

        $result = $this->dataManager->getData($endpoint, $value);
        $expiresValue = (new DateTime())->modify('+1 day');
        $cacheItem
            ->set($result)
            ->expiresAt($expiresValue);

        return $result;
    }


}