<?php
// src/Entity/User.php
namespace App\Entity\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    // Eğer otomatik olarak created_at ve updated_at sütunlarını kullanmak istemiyorsanız, timestamps özelliğini kapatabilirsiniz.
    public $timestamps = false;

    // Eğer tabloya ait birincil anahtar sütunu farklıysa, aşağıdaki şekilde belirtebilirsiniz.
    protected $primaryKey = 'permissionid ';

    public $incrementing = true;

    protected $fillable = ["permissionname", "permissions"];
}
