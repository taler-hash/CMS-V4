<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\UdaValues;

class UdaItemLov extends Model
{
    use HasFactory;
    protected $connection='oracle';
    protected $table ='uda_item_lov';

    public function udaValues(){
        return $this->hasMany(UdaValues::class,'uda_value','uda_value');
    }
}
