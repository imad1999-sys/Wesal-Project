<?php

namespace App\Http\Controllers;
use App\Models\Admins;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  
    public function register(Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
        ]);
        $this->validate($req, [
            'email' => 'required',
        ]);
        $this->validate($req, [
            'password' => 'required',
        ]);

        $admins = new Admins();
        $admins->name = $req->input('name');
        $admins->email = $req->input('email');
        $admins->password = Hash::make($req->input('password'));

        $admins->save();
        return $admins;
    }


    public function login(Request $request)
    {
        
        $admin = Admins::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return self::getResponse(false , "error email or password" , null , 401 );
        }

        $token = $admin->createToken('my-app-token')->plainTextToken;
       
        $response = [
            'admin' => $admin,
            'token' => $token,
            'id' => $admin->id
        ];

        return self::getResponse(true , "You are logged in" ,  $response , 200);
    }
    function displayAllAdmins(){
        return Admins::all();
    }

}
