<?php
require_once "../vendor/autoload.php";

use Illuminate\Database\Capsule\Manager;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post = $_POST["database"];
    $capsule = new Manager;

    // Veritabanı bağlantı ayarlarını yapıyoruz
    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => $post["host"],
        'database'  =>  $post["databasename"],
        'username'  =>  $post["username"],
        'password'  =>  $post["password"],
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);

    // ORM kullanımı için gerekli olan global fonksiyonları yükle
    $capsule->setAsGlobal();

    // Eloquent ORM'i başlatıyoruz
    $capsule->bootEloquent();

    $sqlfile = file_get_contents("assets/install.sql");

    $sqlfile = explode(';', $sqlfile);

    array_pop($sqlfile);

    try {
        Manager::beginTransaction();

        foreach ($sqlfile as $value) {
            $value = trim($value);
            if (!empty($value)) {
                Manager::statement($value);
            }
        }


        Manager::commit();
    } catch (\Exception $e) {
        Manager::rollback();
    }

   

    $configfile = "../src/Configs/Settings.php";
    
    

    require $configfile;

    file_put_contents($configfile, "");
    
    $config["default_database"] = [
        'driver'    => 'mysql',
        'host'      => $post["host"],
        'database'  =>  $post["databasename"],
        'username'  =>  $post["username"],
        'password'  =>  $post["password"],
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ];
    $contents = "<?php \n";
    foreach ($config as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $key2 => $vl) {
                $contents .= '$config' . "['".$key."']" ."['" . $key2 . "']='" . $vl . "';\n";
            }
        }else{
            $contents .= '$config' . "['" . $key . "']='" . $value . "';\n";
        }
       
    }



    file_put_contents($configfile, $contents);
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install</title>
</head>

<body>
    <form action="./index.php" method="post">
        <p>
            <label>Database Host</label>
        </p>
        <p>
            <input type="text" name="database[host]">
        </p>

        <p>
            <label>Database Name</label>
        </p>
        <p>
            <input type="text" name="database[databasename]">
        </p>

        <p>
            <label>Database Username</label>
        </p>
        <p>
            <input type="text" name="database[username]">
        </p>

        <p>
            <label>Database Password</label>
        </p>
        <p>
            <input type="text" name="database[password]">
        </p>
        <p>
            <button>Create</button>
        </p>
    </form>
</body>

</html>