<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function examination(Request $request){

        $pd = $request->input('products');

        $counts = $request->get('count');

        $products = Product::whereIn('id', $pd)->get();
        $warehouses = Warehouse::all();
        $tm = [];
        foreach($products as $index=>$product){
            $materials = $product->materials()->get();
            foreach ($materials as $material){
                $need_to = $material->pivot->quantity * $counts[$index];
                foreach ($warehouses->where('material_id', $material->id)->where('reminder','!=',0) as $warehouse){
                    if ($warehouse->reminder >= $need_to){
                        $wr[] = [
                            "warehouse_id"=>$warehouse->id,
                            "material_name"=>$material->name,
                            "qty"=>$need_to,
                            "price"=> $warehouse->price
                        ];
                        $warehouse->reminder = $warehouse->reminder - $need_to;
                        $need_to = 0;
                    }else{
                        $need_to = $need_to - $warehouse->reminder;
                        $wr[] = [
                            "warehouse_id"=>$warehouse->id,
                            "material_name"=>$material->name,
                            "qty"=>$warehouse->reminder,
                            "price"=> $warehouse->price
                        ];
                        $warehouse->reminder = 0;
                    }
                    if ($need_to == 0){
                        break;
                    }
                }
                if ($need_to > 0){
                    $wr[] = [
                        "warehouse_id"=>null,
                        "material_name"=>$material->name,
                        "qty"=>$need_to,
                        "price"=> null
                    ];
                }
            }
            $result[] = [
                "product_name"=>$product->name,
                "product_count"=>$counts[$index],
                "product_material"=>$wr,
            ];
            $wr = [];
        }


        /*$products->transform(function ($item, $index) use($counts){
            $materials = $item->materials()->get();
            $count = $counts[$index];
            $materials->transform(function ($material) use ($count){
                $need_to = $material->pivot->quantity * $count;

                foreach ($material->warehouses()->get() as $warehouse){
                    if ($warehouse->reminder >= $need_to && $warehouse->reminder != 0){
                        $wr[] = [
                            "warehouse_id"=>$warehouse->id,
                            "material_name"=>$material->name,
                            "qty"=>$need_to,
                            "price"=> $warehouse->price
                        ];
                        $warehouse->reminder = 0;
                    }else{
                        $need_to = $need_to - $warehouse->reminder;
                        $warehouse->reminder = 0;
                        $wr[] = [
                            "warehouse_id"=>$warehouse->id,
                            "material_name"=>$material->name,
                            "qty"=>$warehouse->reminder,
                            "price"=> $warehouse->price
                        ];
                    }
                }
                return $wr;

            });
            return [
                "product_name"=>$item->name,
                "product_count"=>$count,
                "product_material"=>$materials
            ];
        });*/


        return response([
            "result_v1"=>$result
        ]);
    }
}
