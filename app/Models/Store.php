<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ItemLocation;

class Store extends Model
{
    use HasFactory;
    protected $connection='oracle';
    protected $table ='store';

    public function itemLocs(){
        return $this->hasMany(ItemLocation::class, 'loc', 'store');
    }
   
    
}
