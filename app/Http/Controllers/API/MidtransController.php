<?php

namespace App\Http\Controllers\API;

use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Midtrans\Notification;

class MidtransController extends Controller
{
    //
    public function callback(Request $request){
        // Set Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');


        // Buat instance Midtrans Notification
        $notif = new Notification();

        // Assign ke variable untuk memudahkan codingan
        $status = $notif->transaction_status;
        $type = $notif->payment_type;
        $fraud = $notif->fraud_status;
        $order_id = $notif->order_id;

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($order_id);
        // Handle Notifikasi status Midtrans

        // Simpan Transaksi
    }
}
