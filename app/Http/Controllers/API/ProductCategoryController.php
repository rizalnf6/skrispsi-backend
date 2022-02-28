<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('id');
        $show_product = $request->input('show_product');

        if($id){
            $category = ProductCategory::with(['products' ])->find($id);

            if($category)
                return ResponseFormatter::success(
                    $category,
                    'Data kategori berhasil diambil'
                );
            else
                return ResponseFormatter::error(
                    null,
                    'Data kategori tidak ada',
                    404
                );
        }

        // Filter
        $category = ProductCategory::query();
        
        if($name){
            $category->where('name', 'like', '%'.$name.'%');
        };

        if($show_product){
            $category->with('products');
        };

        return ResponseFormatter::success(
            $category->paginate($limit), 
            'Data Kategori Berhasil Diambil'
        );
    }
}