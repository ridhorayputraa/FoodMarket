<?php

namespace App\Http\Controllers;

use App\Http\Requests\FoodRequest;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $food = Food::paginate(10);

        return view('food.index', [
            'food' => $food
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  Untuk C -> Create
    public function create()
    {
        return view('food.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  Untuk C -> Create tapi Logic nya
    public function store(FoodRequest $request)
    {
        // MENGAMBIL DATA SEMUA REQUEST DARI VALIDASI
        //  USERREQUEST
        $data = $request->all();
        $data['picturePath'] = $request->file('picturePath')->store('assets/food', 'public');

        Food::create($data);

        return redirect()->route('food.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
       return view('food.edit', [
            'item' => $food
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FoodRequest $request, Food $food)
    {
        //
         $data = $request->all();
        if($request->file('picturePath')){
              $data['picturePath'] = $request->file('picturePath')->store('assets/food', 'public');
        }

        // Assign kembali value nya
        $food->update($data);

        return redirect()->route('food.index');
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
          // langsung di delete
        $food->delete();
        // kemudian redirect ke halaman dashboard
        return redirect()->route('food.index');
    }
}
