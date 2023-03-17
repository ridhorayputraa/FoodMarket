<?php

namespace App\Http\Controllers\API;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

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
        $transaction = Transaction::with(['food', 'user'])
        ->where('user_id', Auth::user()->id);

        // Filtering berdasarkan nama Food id
        if($food_id){
        // bisa dikatakan begini 'vape_id = $vape_id'
            $transaction->where('food_id', $food_id);
        }

        // Filtering berdasarkan status
        if($status){
            $transaction->where('status', $status);
        }


        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Data list transaksi berhasil di ambil'
        );

    }

    // API Transaksi Update
    public function update(Request $request, $id){
        $transaction=  Transaction::findOrFail($id);

        // update data setelah di ambil
        // akan di jalankan bila ada yang transaksi
        $transaction->update($request->all());
        return ResponseFormatter::success(
            $transaction,
            'Transaksi berhasil di perbarui'
        );
    }

    // API Checkout dengan midtrans
    public function checkout(Request $request){
        $request->validate([
            'food_id' => 'required|exists:food,id'
            // arahin ke table food dan cek id nya ada atau nggak
        ]);
    }
}
