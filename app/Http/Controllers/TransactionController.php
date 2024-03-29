<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // Tambahkan relasi nya
        $transaction = Transaction::with(['food', 'user'])->paginate(10);
        return view('transactions.index', [
            'transactions' => $transaction
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  Langsung panggil model Transaction
    public function show(Transaction $transaction)
    {
        //
        return view('transactions.detail', [
            'item' => $transaction
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        // langsung di delete
        $transaction->delete();
        // kemudian redirect ke halaman dashboard
        return redirect()->route('transactions.index');
    }

    // Buat MethodBaru
    public function changeStatus(Request $request, $id, $status){
    //    Panggil model jika ada id nya aja
        $transactions = Transaction::findOrFail($id);

        $transactions->status = $status;
        // ambil status dari parameter
        $transactions->save();

        // masukan route show -> untuk || parameter untuk mengarhkan ke Id yang sesuai
        return redirect()->route('transactions.show', $id);
    }

}
