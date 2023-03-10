<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    // 1 fungsi ini  akan menghandle semua request
    // perlu menyiapkan beberapa opsi untuk filter
    // Berdasarkan ID, Berdasarlan Harga, Berdasarkan Tipe

    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        // LIMIT membatasi hanya 6 Request
        $name = $request->input('name');
        $types = $request->input('types');


        // Filtering berdasarkan harga
        // terkecil -> terbesar
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');


        // Filtering berdasarkan rating
        $rate_from = $request->input('rate_from');
        $rate_to = $request->input('rate_to');

        // pengambilan data berdasarkan ID
        if($id){
         $food = Food::find($id);

         if($food){
            return ResponseFormatter::success(
                $food,
                'Data produk berhasil diambil'
            );
         }else{
            return ResponseFormatter::error(
                null,
                'Data produk tidak di temukan',
                404
            );
         }

        }
    }
}
