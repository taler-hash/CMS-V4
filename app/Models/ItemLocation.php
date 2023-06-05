<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Store;
use App\Models\ItemSupplier;

class ItemLocation extends Model
{
    use HasFactory;
    protected $connection='oracle';
    protected $table ='item_loc';

}
