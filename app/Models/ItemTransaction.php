<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTransaction extends Model
{
    protected $table = 'item_transactions';

    protected $fillable = ['item_id','type','quantity','petugas_id','pengguna_id','transaction_date','note'];

    public function item(){ 
        return $this->belongsTo(Item::class,'item_id');
    }

    public function petugas(){ 
        return $this->belongsTo(Petugas::class,'petugas_id');
    }

    public function pengguna(){ 
        return $this->belongsTo(Pengguna::class,'pengguna_id'); 
    }
}