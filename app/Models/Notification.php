<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;


    /**
     * @param $user
     * @param $description
     */
    public function create($description, $category, $user)
    {
        $notify = new Notification();
        $notify->description = $description;
        $notify->category = $category;
        $notify->user_id = $user;
        $notify->save();
    }



    public function user(){
        return $this->belongsTo(User::class);
    }
}
