<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model {
    use HasFactory;

    // indicamos la tabla que va a modificar
    protected $table = 'images';


    // indicar la relacion del modelo one to many
    public function comments() {
        return $this->hasMany('App\Models\Comment')->orderBy('id', 'desc');
    }

    // Relacio One to many
    public function likes() {
        return $this->hasMany('App\Models\Like');
    }

    // relacion many to one
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }



}