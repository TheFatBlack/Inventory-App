<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $table = 'item_categories';

    protected $fillable = [
        'name',
        'code',
        'description',
        'image',
        'created_by'
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'item_category_id');
    }
}
