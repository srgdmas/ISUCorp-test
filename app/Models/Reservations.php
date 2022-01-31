<?php

namespace App\Models;

use Database\Factories\ReservationsFactory;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    protected $guarded = ['id'];

    protected static function newFactory(): ReservationsFactory {
        return ReservationsFactory::new();
    }

    public function contact_type() {
        return $this->belongsTo(ContactsTypes::class);
    }

}
