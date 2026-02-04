<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'penggunas';

    protected $fillable = ['user_id','name','username','email','password','nip','no_hp','photo'];

    protected $hidden = ['password'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
