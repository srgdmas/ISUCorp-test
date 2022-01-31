<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];

    public function permisos() {
        return $this->belongsToMany(Permisos::class, 'roles_permisos', 'roles_id', 'permisos_id');
    }

}
