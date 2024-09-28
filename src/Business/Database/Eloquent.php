<?php

namespace App\Business\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent extends Database
{
    public function __construct()
    {
        $this->init();
    }
    function init()
    {
        $capsule = new Capsule;

        // Veritabanı bağlantı ayarlarını yapıyoruz
        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => 'doctrine',
            'username'  => 'root',
            'password'  => 'Ahmet.4336',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        // ORM kullanımı için gerekli olan global fonksiyonları yükle
        $capsule->setAsGlobal();

        // Eloquent ORM'i başlatıyoruz
        $capsule->bootEloquent();
    }
}
