<?php

namespace App\Business\Cache;

interface ICache
{
    function getAndSave(string $key,$data);
    function get(string $key);
    function delete(string $key);
    function clear($key);
    function isExpire($key);
}


