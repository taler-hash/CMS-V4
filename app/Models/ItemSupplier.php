<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Supplier;
use App\Models\ItemMaster;

class ItemSupplier extends Model
{
    use HasFactory;
    protected $connection='oracle';
    protected $table ='item_supplier';

    public function itemMaster(){
        return $this->belongsTo(ItemMaster::class, 'item', 'item');
    }

    public function supplier(){
        return $this->hasOne(Supplier::class,'supplier','supplier');
    }

    public function udaItemLov(){
        return $this->belongsTo(udaItemLov::class,'item','item');
    }

    public function scopeSupplierCode($query, $supplierCode)
    {
        $query->where('supplier', $supplierCode);
    }

    public function scopeHasConcessionRate($query){
        $query->whereNotNull('concession_rate');
    }
}
