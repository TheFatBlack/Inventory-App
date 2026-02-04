<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model
{
    protected $table = 'item_stocks';

    protected $fillable = ['item_id','stock'];

    public function item(){ 
        return $this->belongsTo(Item::class,'item_id');
    }

}