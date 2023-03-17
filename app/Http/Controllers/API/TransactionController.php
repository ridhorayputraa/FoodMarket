<?php

namespace App\Http\Controllers\API;

use Exception;
use Midtrans\Snap;
use App\Models\Food;
use Midtrans\Config;
use App\Models\Transaction;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
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
            'food_id' => 'required|exists:food,id',
            // arahin ke table food dan cek id nya ada atau nggak
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required',
            'total' => 'required',
            'status' => 'required'
        ]);

        $transaction = Transaction::create([
            'food_id' => $request->food_id,
            'user_id' => $request->user_id,
            'quantity' => $request->quantity,
            'total' => $request->total,
            'status' => $request->status,
            'payment_url' => '',
            // akan di update setelah nembak mitrans
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Panggil transaksi yang tadi dibuat
        $transaction = Transaction::with(['food', 'user'])->find($transaction->id);

        // Membuat Transaksi Midtrans
        $midtrans = [
            // referensi datanya ada di 'snap-docs.midtrans.com->Request Body
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => (int) $transaction->total,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ],
            'enable_payments' => ['gopay', 'bank_transfer'],
            // enable payment isi untuk payment apa aja
            'vtweb' => []
        ];
        // Memanggil midtrans

        try{
            // Ambil halaman payments midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            // update data nya
            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            // Mengembalikan Data ke API
            return ResponseFormatter::success(
                $transaction,
                'Transaksi berhasil'
            );

        }catch(Exception $e){
            return ResponseFormatter::error($e->getMessage(), 'Transaksi Gagal');
        }

    }
}
