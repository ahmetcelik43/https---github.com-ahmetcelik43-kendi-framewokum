<?php

namespace App\Controllers;

class ImageController extends BaseController
{
    public function index($path = "")
    {
        $urlImage = url();
        $parsedUrl = parse_url($urlImage);
        $filename = str_replace(config("Settings")["base_path"], "", BASEPATH . $parsedUrl['path']);
        $width = $_GET["w"];
        $height = $_GET["h"];
        $quality = $_GET["q"];
        $crop = $_GET["c"];
        imageResize2($filename, $width, $height, $crop, $quality);
    }
}
