<?php
function view($path, $data = [])
{
    include BASEPATH . "/src/Views/$path.php";
    header("content-type:text/html");
    exit();
}
function viewData($path, $data = [])
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
    echo ($value);
}
function encryptData($data)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', ENCRYPTION_KEY, 0, $iv);
    return base64_encode($encryptedData . '::' . $iv);
}

function decryptData($encryptedData)
{
    list($encryptedData, $iv) = explode('::', base64_decode($encryptedData), 2);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', ENCRYPTION_KEY, 0, $iv);
}


function imageResize($url, $width, $height, $crop = false, $quality = 100)
{
    // URL'den resmi indir
    $imgContent = file_get_contents($url);
    if ($imgContent === false) {
        return "Image could not be downloaded.";
    }

    // Geçici bir dosya adı oluştur
    $tempFile = tempnam(sys_get_temp_dir(), 'img');
    
    // Geçici dosyaya indirilen resmi kaydet
    file_put_contents($tempFile, $imgContent);

    // Resim formatını belirle
    $imageInfo = getimagesize($tempFile);
    if (!$imageInfo) {
        unlink($tempFile); // Geçici dosyayı sil
        return "Invalid image.";
    }

    list($w, $h) = $imageInfo;
    $type = $imageInfo['mime'];

    // Resmi resim kaynağına dönüştür
    switch ($type) {
        case 'image/jpeg':
            $img = imagecreatefromjpeg($tempFile);
            break;
        case 'image/png':
            $img = imagecreatefrompng($tempFile);
            break;
        case 'image/gif':
            $img = imagecreatefromgif($tempFile);
            break;
        case 'image/webp':
            $img = imagecreatefromwebp($tempFile);
            break;
        default:
            unlink($tempFile);
            return "Unsupported image type.";
    }

    if (!$img) {
        unlink($tempFile);
        return "Failed to create image from source.";
    }

    // Boyutlandırma işlemi
    if ($crop) {
        $ratio = max($width / $w, $height / $h);
        $x = ($w - $width / $ratio) / 2;
        $y = ($h - $height / $ratio) / 2;
        $w = $width / $ratio;
        $h = $height / $ratio;
    } else {
        $ratio = min($width / $w, $height / $h);
        $newWidth = $w * $ratio;
        $newHeight = $h * $ratio;
    }

    // Yeni bir resim oluştur ve yeniden boyutlandır
    $newImg = imagecreatetruecolor($newWidth, $newHeight);
    
    // Transparanlık için ayar (PNG ve GIF)
    if ($type == 'image/png' || $type == 'image/gif') {
        imagecolortransparent($newImg, imagecolorallocatealpha($newImg, 0, 0, 0, 127));
        imagealphablending($newImg, false);
        imagesavealpha($newImg, true);
    }

    imagecopyresampled($newImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $w, $h);

    // Yeni boyutlandırılan resmi ekrana göster
    header('Content-Type: ' . $type);
    
    switch ($type) {
        case 'image/jpeg':
            imagejpeg($newImg, null, $quality);
            break;
        case 'image/png':
            imagepng($newImg, null, 9 - ($quality / 11)); // PNG kalite ayarı
            break;
        case 'image/gif':
            imagegif($newImg);
            break;
        case 'image/webp':
            imagewebp($newImg, null, $quality);
            break;
    }

    // Belleği temizle
    imagedestroy($img);
    imagedestroy($newImg);
    unlink($tempFile); // Geçici dosyayı sil
}

function imageResize2($src, $width, $height, $crop = false, $quality = 1)
{
    if (!list($w, $h) = getimagesize($src)) echo "Unsupported picture type!";
    $type = strtolower(substr(strrchr($src, "."), 1));
   
    /*$seconds_to_cache = 3600;
    $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
    header("Expires: $ts");
    header("Pragma: cache");
    header("Cache-Control: max-age=$seconds_to_cache");
    header('Content-type: ' . $ctype);
    */
    switch ($type) {
        case 'bmp':
            $img = imagecreatefromwbmp($src);
            break;
        case 'gif':
            $img = imagecreatefromgif($src);
            break;
        case 'jpg':
            $img = imagecreatefromjpeg($src);
            break;
        case 'png':
            $img = imagecreatefrompng($src);
            break;
        case 'webp':
            $img = imagecreatefromwebp($src);
            break;
        default :
            $img = imagecreatefromjpeg($src);
    }
    // //


    if ($crop) {
        $ratio = min($width / $w, $height / $h);
        $y_width = $w * $ratio;
        $y_height = $h * $ratio;
        $px = ($width - $y_width) / 2;
        $py = ($height - $y_height) / 2;

    } else {
        // if($w < $width and $h < $height) return "Picture is too small!";
        $ratio = min($width / $w, $height / $h);
        $y_width = $w * $ratio;
        $y_height = $h * $ratio;
        $width = $y_width;
        $height = $y_height;
        $px = 0;
        $py = 0;
    }

    $new = imagecreatetruecolor((int)$width, (int)$height);

    if ($type == "gif" or $type == "png") {
        $color = imagecolorallocatealpha($new, 0, 0, 0, 127); //fill transparent back
        imagefill($new, 0, 0, $color);
        imagesavealpha($new, true);
    } else {
        $whiteBackground = imagecolorallocate($new, 255, 255, 255);
        imagefill($new, 0, 0, $whiteBackground);
    }
    imagecopyresampled($new, $img, $px, $py, 0, 0, (int)$y_width, (int)$y_height, $w, $h);
    //debug($new);
    
    switch ($type) {
        case 'bmp':
            header('content-type:image/bmp');
            imagewbmp($new, null, $quality);
            break;
        case 'gif':
            header('content-type:image/gif');
            imagegif($new, null, $quality);
            break;
        case 'jpg':
            header('Content-Type: image/jpeg');
            imagejpeg($new, null, 100);
            //debug($result);

            break;
        case 'png':
            header('content-type:image/png');
            imagepng($new, null, 100);
            break;
        case 'webp':
            header('content-type:image/webp');
            imagewebp($new, null, 100);
            break;
        default:
            header('content-type:image/jpeg');
            imagejpeg($new, null, 100);
    }

    imagedestroy($new);
    imagedestroy($img);

}

function loadImage($url, $width = 300, $height = 300, $crop = 0)
{
    $url = preg_replace('/X\d+X\d+X\d+/', '', $url);
    $urller[] = url(ispath: true);
    $gelenler = parse_url($url);
    if ($gelenler['host'] != "") {
        $gelen = $gelenler['scheme'] . '://' . $gelenler['host'] . "/";
    } else {
        $gelen = url(ispath: true) . "/";
    }

    if (in_array($gelen, $urller) == false) {
        $resim = $url;
    } else {
        $resimler = explode(".", $gelenler['path']);
        $resim = $gelen . $resimler[0] . "X" . $width . "X" . $height . "X" . $crop . "." . end($resimler);
    }
    return $resim;
}
function url($ispath = true)
{
    // Protokol (http veya https)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    // Sunucu adı (domain)
    $host = $_SERVER['HTTP_HOST'];
    if (!$ispath) return $protocol . $host;

    // İstek URI'si (path)
    $uri = $_SERVER['REQUEST_URI'];
    // Tam URL
    return $protocol . $host . $uri;
}

?>
