<?php

namespace App\Models;

use App\Models\OldsPasswords;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Role;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    use LogsActivity;
    protected static $logOnlyDirty = true;
//    protected static $logAttributes = ['*'];
    protected static $logAttributes = ['email', 'phone'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'lastname','mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['fullname'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function roles()
    {
        return $this->belongsTo(Role::class);
    }

    public function old_passwords()
    {
        return $this->belongsTo(OldsPasswords::class);
    }

    public function provinces()
    {
        return $this->belongsTo(Provinces::class);
    }

    public function especialidades()
    {
        return $this->belongsTo(Especialidades::class);
    }

    public function tipos_clientes()
    {
        return $this->belongsTo(TiposClientes::class);
    }

    public function promotor()
    {
        return $this->belongsTo(User::class);
    }

    public function billing_user_concepts()
    {
        return $this->hasMany(BillingUserConcepts::class);
    }

    public function permisos() {
        return $this->belongsToMany(Permisos::class, 'users_permisos', 'users_id', 'permisos_id');
    }

    public function fullname()
    {
        if ($this->name) {
            return $this->name . ' ' . $this->lastname;
        } else {
            return $this->email;
        }
    }

    public function role_permisos()
    {
        return Role::find(auth()->user()->roles_id);
    }

    public function getRolePermisosAttribute()
    {
        return $this->role_permisos();
    }

    public function getFullnameAttribute()
    {
        return $this->fullname();
    }

}
