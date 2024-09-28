<?php

namespace App\Entity\Models;

use App\Business\Crud\Crud;
use Illuminate\Database\Eloquent\Casts\Attribute as CastsAttribute;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use Crud;

    protected $table = 'members';

    public $timestamps = true;

    const CREATED_AT = 'member_created_at';

    const UPDATED_AT = 'member_updated_at';

    public $primaryKey = 'member_id';

    protected $appends = ["status"];

    protected function getStatusAttribute()
    {
        return "<input " . ($this->member_status == 1 ? "checked" : "") . " type='checkbox' name='status' class='status' value='1'>";
    }

    protected function memberPassword(): CastsAttribute
    {
        return CastsAttribute::make(
            get: fn (string $value) => $value,
            set: fn (string $value) => sha1(md5($value)),
        );
    }

    public $incrementing = true;

    protected $fillable = ["member_name", "member_email", "member_password", "member_status", "member_password"];
}
