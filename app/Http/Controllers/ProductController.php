<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Read all products
        return Product::all();
    }

    public function store(Request $request)
    {
        //เช็คสิทธิ์ (role) ว่าเป็น admin (1)
        $user = auth()->user();

        if($user->tokenCan("1")){

            // Validate form
            $request->validate([
                'name' => 'required|min:3',
                'slug' => 'required',
                'price' => 'required'
            ]);

            // กำหนดตัวแปรรับค่าจากฟอร์ม
            $data_product = array(
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'slug' => $request->input('slug'),
                'price' => $request->input('price'),
                'user_id' => $user->id
            );

            // Create data to tabale product
            return Product::create($data_product);

        }else{
            return [
                'status' => 'Permission denied to create'
            ];
        }
    }

    public function show($id)
    {
        return Product::find($id);
    }

    //public function update(Request $request, Product $product)
    public function update(Request $request, $id)
    {
        // เช็คสิทธิ์ (role) ว่าเป็น admin (1)
        $user = auth()->user();

        if($user->tokenCan("1")){

            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required'
            ]);

            $data_product = array(
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'slug' => $request->input('slug'),
                'price' => $request->input('price'),
                'user_id' => $user->id
            );

            $product = Product::find($id);
            $product->update($data_product);

            return $product;

        }else{
            return [
                'status' => 'Permission denied to create'
            ];
        }
    }

    //public function destroy(Product $product)
    public function destroy($id)
    {

        // เช็คสิทธิ์ (role) ว่าเป็น admin (1)
        $user = auth()->user();

        if($user->tokenCan("1")){
            return Product::destroy($id);
        }else{
            return [
                'status' => 'Permission denied to create'
            ];
        }

    }
}
