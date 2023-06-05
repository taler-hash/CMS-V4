<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\ItemLocation;
use App\Models\ItemMaster;
use App\Models\ItemSupplier;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Cache;

class contractController extends Controller
{
    public function getAll(Request $request){
        
        $supplier = Supplier::select('supplier','sup_name')->where('supplier',$request->searchString)->get();

        $stores = Supplier::select('item_loc.loc', 'store.store_name')
        ->leftJoin('item_supplier', 'sups.supplier', '=', 'item_supplier.supplier')
        ->leftJoin('item_loc', 'item_supplier.item', '=', 'item_loc.item')
        ->leftJoin('store', 'item_loc.loc', '=', 'store.store')
        ->where('item_supplier.supplier', '=', $request->searchString)
        ->where('item_loc.status', '=', 'A')
        ->distinct()
        ->orderBy('item_loc.loc', 'asc')
        ->get();
        
        $brandsWithConcessionRate = Itemmaster::selectRaw('uda_values.uda_value, uda_values.uda_value_desc, item_supplier.concession_rate')
        ->leftJoin('item_supplier', 'item_supplier.item', '=', 'item_master.item')
        ->leftJoin('uda_item_lov', 'uda_item_lov.item', '=', 'item_master.item')
        ->leftJoin('uda_values', 'uda_values.uda_value', '=', 'uda_item_lov.uda_value')
        ->where('item_supplier.supplier', $request->searchString)
        ->where('uda_values.uda_id', 9)
        ->where('uda_values.uda_value', '>=', 20)
        ->where('item_supplier.concession_rate', '<=', 100)
        ->whereNotNull('item_supplier.concession_rate')
        ->orderBy('uda_values.uda_value_desc', 'asc')
        ->distinct()
        ->get();

        $groups = ItemMaster::select('groups.group_no', 'groups.group_name', 'deps.dept', 'deps.dept_name', 'class.class', 'class.class_name', 'subclass.subclass', 'subclass.sub_name')
            ->join('item_supplier', 'item_supplier.item', '=', 'item_master.item')
            ->join('deps', 'deps.dept', '=', 'item_master.dept')
            ->join('groups', 'groups.group_no', '=', 'deps.group_no')
            ->join('class', 'class.dept', '=', 'item_master.dept')
            ->join('subclass', function($join) {
                $join->on('subclass.dept', '=', 'item_master.dept')
                     ->on('subclass.class', '=', 'class.class');
            })
            ->where('item_supplier.supplier', '=', $request->searchString)
            ->distinct()
            ->get();
        
        $data = ['supplier'=> $supplier, 'stores'=>$stores,'brandswithConcessionRate'=>$brandsWithConcessionRate, 'subDept'=>$groups];
        //To save in storage as json
        //Storage::disk('local')->put('test.json', json_encode($data));
       
        return response(['supplier'=> $supplier, 'stores'=>$stores,'brandswithConcessionRate'=>$brandsWithConcessionRate,'subDept'=>$groups]);
    }

}
