<?php
// src/Entity/User.php
namespace App\Entity\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    public $timestamps = false;

    protected $primaryKey = 'userid';

    protected $appends = ["welcome"];

    protected function getWelcomeAttribute()
    {
        return "Hoş Geldin " . $this->username;
    }

    public $incrementing = true;


    protected $fillable = ["username", "useremail", "userpermission"];

    public function permission()
    {
        return $this->belongsTo(Permission::class, "userpermission", "permissionid");
    }
}
