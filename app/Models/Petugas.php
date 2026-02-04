<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';

    protected $fillable = ['user_id','name','username','email','password','nip','no_hp','photo'];

    protected $hidden = ['password'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function items(){ 
        return $this->hasMany(Item::class,'petugas_id'); 
    }
}