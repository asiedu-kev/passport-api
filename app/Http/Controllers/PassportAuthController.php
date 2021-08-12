<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class PassportAuthController extends Controller
{
    protected $successCode = 200;
    protected $errorCode = 401;

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);
        $user = User::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'password' =>bcrypt($request->password)]
        );

        $token = $user->createToken('LaravelAuthApp')->accessToken();
        $message = "Enregistrement effectue !";

        return response()->json(['token' => $token,'message' => $message],$this->successCode);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (auth()->attempt($data)){
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken();
            $message = "Connexion reussie !";
            return response()->json(['token' => $token, 'message' => $message],$this->successCode);
        }
        else {
            $message = "Connexion echouee !";
            return response()->json(['message' => $message],$this->errorCode);
        }  

    }

}
