<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = ['code','name','unit','description','item_category_id','petugas_id','photo'];

    public function category(){ 
        return $this->belongsTo(ItemCategory::class,'item_category_id'); 
    }

    public function petugas(){ 
        return $this->belongsTo(Petugas::class,'petugas_id');
    }

    public function stock(){ 
        return $this->hasOne(ItemStock::class,'item_id');
    }
}