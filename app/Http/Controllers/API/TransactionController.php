<?php

namespace App\Http\Controllers\API;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    //
     public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        // LIMIT membatasi hanya 6 Request
        $food_id = $request->input('food_id');
        $status = $request->input('status');



        // pengambilan data berdasarkan ID
        if($id){
         $transaction = Transaction::with(['food', 'user'])->find($id);

         if($transaction){
            return ResponseFormatter::success(
                $transaction,
                'Data transaksi berhasil diambil'
            );
         }else{
            return ResponseFormatter::error(
                null,
                'Data transaksi tidak di temukan',
                404
            );
         }

        }

        // Fetching sisanya
        // untuk query yang di luar ID


        // siapkan query nya dulu menggunakan where, untuk mengambil
        // data yang spesifik hanya yang login
        $transaction = Tra::;

        // Filtering berdasarkan nama
        if($name){
            $food->where('name', 'like', '%' . $name . '%');
        }


        // Filtering berdasarkan types
        if($types){
            $food->where('types', 'like', '%' . $types . '%');
        }

        // Filtering berdasarkan harga
        if($price_from){
            $food->where('price' , '>=', $price_from);
        }

        if($price_to){
            $food->where('price', '<=', $price_to);
        }

            // Filtering berdasarkan Rating
        if($rate_from){
            $food->where('rate' , '>=', $rate_from);
        }

        if($rate_to){
            $food->where('rate', '<=', $rate_to);
        }

        return ResponseFormatter::success(
            $food->paginate($limit),
            'Data list produk berhasil di ambil'
        );

    }
}
