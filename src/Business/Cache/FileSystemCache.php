<?php

namespace App\Business\Cache;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class FileSystemCache implements ICache
{
    private $cacheManager;
    public function __construct()
    {
        $this->cacheManager = new FilesystemAdapter();
    }

    function getAndSave(string $key, $data)
    {
        $this->cacheManager = new FilesystemAdapter();
        $cacheItem = $this->cacheManager->getItem($key);
        if (!$cacheItem->isHit()) {
            $expire = config("Settings", "cacheExpire");
            $cacheItem->set($data);
            $cacheItem->expiresAfter($expire);
            $this->cacheManager->save($cacheItem);
        }
        return $data;
    }
    function isExpire($key)
    {
        $cacheItem = $this->cacheManager->getItem($key);
        return $cacheItem->isHit();
    }
    function get($key)
    {
        $cacheItem = $this->cacheManager->getItem($key);
        return $cacheItem->get();
    }
    function delete(string $key)
    {
        $this->cacheManager->deleteItem($key);
    }
    function clear($key)
    {
        $this->cacheManager->deleteItem($key);
    }
}
