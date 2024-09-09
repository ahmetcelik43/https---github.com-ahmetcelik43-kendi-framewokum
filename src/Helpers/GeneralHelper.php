<?php
function view($path, $data=[])
{
    include BASEPATH . "/src/Views/$path.php";
    header("content-type:text/html");
    exit();
}
function viewData($path, $data=[])
{
    header("content-type:text/html");
    ob_start();
    include BASEPATH . "/src/Views/$path.php";
    $output = ob_get_clean();
    return $output;
}
function config($file, $key = null)
{
    include BASEPATH . "/src/Configs/$file.php";
    if ($key) {
        return $config[$key];
    }
    return $config;
}
function debug($value)
{
    print_r($value);
    die();
}
function finish($value)
{
    echo($value);
}
