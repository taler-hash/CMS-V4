<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ItemSupplier;

class Supplier extends Model
{
    use HasFactory;
    protected $connection='oracle';
    protected $table ='sups';

    public function itemSuppliers(){
        return $this->hasMany(ItemSupplier::class, 'supplier', 'supplier');
    }
}
