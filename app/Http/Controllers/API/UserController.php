<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function login(Request $request){
        // gunakan try catcth untuk konjdisi terpenuhi/tidak
        try{
        // Validasi
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);
        }
    }
}
