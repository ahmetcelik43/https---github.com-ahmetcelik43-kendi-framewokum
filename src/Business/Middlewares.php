<?php

namespace App\Business;

abstract class Middlewares
{
    abstract public function before();
    abstract public function after();
}
