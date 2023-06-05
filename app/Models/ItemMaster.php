<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ItemSupplier;

class ItemMaster extends Model
{
    use HasFactory;
    protected $connection='oracle';
    protected $table ='item_master';

    public function itemSupplier(){
        return $this->hasOne(ItemSupplier::class, 'item', 'item');
    }
}
