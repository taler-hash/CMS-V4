<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UdaValues extends Model
{
    use HasFactory;
    protected $connection='oracle';
    protected $table ='uda_values';
}
