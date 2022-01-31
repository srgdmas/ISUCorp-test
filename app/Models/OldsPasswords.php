<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OldsPasswords extends Model
{
    protected $guarded = ['id'];

    protected $hidden = [
        'password',
    ];
}
