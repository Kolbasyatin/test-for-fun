<?php

declare(strict_types=1);


namespace App\Integration;


use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class DataManagerFactory
{
    public static function getDataManager(bool $isUseCache, ?bool $stubClient = false)
    {
        //** Как именно сюда попадут данные для авторизации
        // http клиента сейчас неважно
        // конечно я бы использовал service container и вопрос бы отпал сам собой.
        // */
        $options = [
            'userName' => 'someUserName',
            'password' => 'somePassword'
        ];
        $dataProvider = $stubClient ? new StubDataProvider() : new HttpDataProvider($options);

        $dataManager = new HttpDataManager($dataProvider);

        if ($isUseCache) {
            $cache = new FilesystemCachePool(new Filesystem(new Local('/tmp')));
            $dataManager = new CachedDataManager($dataManager, $cache);
        }

        return $dataManager;
    }
}