<?php
// src/Entity/User.php
namespace App\Entity\Models;
use Illuminate\Database\Eloquent\Model;

class Migrations extends Model
{
    protected $table = 'migrations';

    // Eğer otomatik olarak created_at ve updated_at sütunlarını kullanmak istemiyorsanız, timestamps özelliğini kapatabilirsiniz.
    public $timestamps = false;

    // Eğer tabloya ait birincil anahtar sütunu farklıysa, aşağıdaki şekilde belirtebilirsiniz.
    protected $primaryKey = 'version';

    public $incrementing = false;

    protected $fillable = ["version","executed_at"];
}
