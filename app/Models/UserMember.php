<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class UserMember extends Model
{
    protected $table = 'user_member';
    protected $fillable = [
        'user_id','member_id'
    ];

}
