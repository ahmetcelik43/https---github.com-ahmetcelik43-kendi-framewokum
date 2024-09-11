<?php

namespace App\Configs;

class Session implements \SessionHandlerInterface
{
    private static $savePath = BASEPATH . '/src/Sessions';

    // open() metodunun imzasını PHP 8 uyumlu hale getiriyoruz
    public function open(string $savePath, string $sessionName): bool
    {
        $this->savePath = $savePath;
        if (!is_dir($this->savePath)) {
            mkdir($this->savePath, 0700);
        }
        return true;
    }

    // close() metodu void yerine bool dönmeli
    public function close(): bool
    {
        return true;
    }

    // read() metodunun imzası PHP 8'e göre string dönmeli
    public function read(string $sessionId): string
    {
        $file = "$this->savePath/sess_$sessionId";
        if (!file_exists($file)) {
            return '';  // Boş string dönmelidir
        }

        $data = file_get_contents($file);
        return decryptData($data);  // Şifreli veriyi çöz ve döndür
    }

    // write() metodu bool dönmeli ve string parametre almalı
    public function write(string $sessionId, string $data): bool
    {
        $file = "$this->savePath/sess_$sessionId";
        $encryptedData = encryptData($data);  // Veriyi şifrele
        return file_put_contents($file, $encryptedData) !== false;  // Dosyaya yaz ve başarılıysa true döndür
    }

    // destroy() metodu bool dönmeli
    public function destroy(string $sessionId): bool
    {
        $file = "$this->savePath/sess_$sessionId";
        if (file_exists($file)) {
            unlink($file);  // Dosyayı sil
        }
        return true;
    }

    // gc() metodu bool dönmeli ve int parametre almalı
    public function gc(int $maxLifetime): int|false
    {
        foreach (glob("$this->savePath/sess_*") as $file) {
            if (filemtime($file) + $maxLifetime < time()) {
                unlink($file);  // Eski dosyaları sil
            }
        }
        return true;
    }
    public static function init() : void
    {
        session_set_cookie_params([
            'lifetime' => 3600,  // 1 saat sonra çerez geçersiz hale gelir
            'path' => '/',  // Tüm sitede geçerli
            'secure' => false,  // HTTPS ile gönder
            'httponly' => true,  // JavaScript erişimini engelle
            'samesite' => 'Lax',  // Çapraz site taleplerine sınırlama getir
        ]);

        session_set_save_handler(new Session(), true);

        // Oturum yolu (varsayılan /tmp olabilir veya özelleştirebilirsiniz)
        session_save_path(self::$savePath);  // Oturum dosyalarının saklanacağı dizini belirleyin

        session_start();  // Oturumu başlat

    }
}
