<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // Untuk validasi password Register
    use PasswordValidationRules


    //
    public function login(Request $request){
        // gunakan try catcth untuk konjdisi terpenuhi/tidak
        try{
        // Validasi
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            // Mengecek credentials (login)
            $credentials = request(['email', 'password']);

            if(!Auth::attempt($credentials)){
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500 );
            }

            // Jika hash tidak sesuai maka beri error
            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password, [])){
                throw new \Exception('Invalid Credentials');
            }

            // Jika berhasil maka loginkan
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return  ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');

        } catch(Exception $error){
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function register(Request $request){
        try{
            $request->validate([
                'name' => ['required', 'string', 'max:20'],
                'email' => ['required', 'string', 'email', 'max:20', 'unique:users'],
                'password' => $this->passwordRules()
            ]);

            User::create([
                'name' => $request-> name,
                'email' => $request->email,
                'address' => $request->address,
                'houseNumber' => $request->houseNumber,
                'phoneNumber' => $request->phoneNumber,
                'city' => $request->city,
                'password' => Hash::make($request->password),
            ]);

            // setUser
            $user = User::where('email', $request->email)->first();

            // sekalian login berikan token
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ]);

        }catch(Exception $error){
            return ResponseFormatter::error([
                'message' => 'something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }

    }


    public function logout(Request $request){
        // Ambil siapa yang sudah login
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');

    }


    // Mengambil Data profile user yang sedang Login
    public function fetch(){
        return ResponseFormatter::success($request->user(), 'Data profile user berhasil di ambil');
    }


    // Update Profile / apabila ingin mengganti profile yang sudah ada
    public function UpdateProfile(Request $request){
        // ambilSemuaDatanya ke Request
        $data = $request->all();
        // Ambil semua field
        $user = Auth::user();
        $user->update($data);

        return ResponseFormatter::success($user, 'Profile Updated');
    }


}
