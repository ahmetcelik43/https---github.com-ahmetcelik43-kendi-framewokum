<?php
// src/Entity/User.php
namespace App\Entity\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    // Eğer otomatik olarak created_at ve updated_at sütunlarını kullanmak istemiyorsanız, timestamps özelliğini kapatabilirsiniz.
    public $timestamps = false;

    // Eğer tabloya ait birincil anahtar sütunu farklıysa, aşağıdaki şekilde belirtebilirsiniz.
    protected $primaryKey = 'userid';

    public $incrementing = true;

    protected $fillable = ["username","useremail","userpermission"];

    public function permission()
    {
        return $this->belongsTo(Permission::class, "userpermission", "permissionid");
    }
}
