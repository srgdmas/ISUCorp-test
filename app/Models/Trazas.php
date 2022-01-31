<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trazas extends Model
{
    protected $guarded = ['id'];

    public function users() {
        return $this->belongsTo(User::class);
    }
}
