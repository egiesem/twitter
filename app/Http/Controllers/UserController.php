<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $dataAttempt = array(
            'email' => $request->email,
            'password' => $request->password
        );

        if(Auth::attempt($dataAttempt)){
            // $jabatan = array_values($jabatan);
            return response()->json([
                'error' => false, 
                'next' => 'status' 
            ]);
        }

        return response()->json([
            'error' => true,
            'pesan' => 'username atau password salah!'
        ]);
    }


    public function register(Request $request)
    {
        $this->validate($request, [
            'namer' => 'required',
            'emailr' => 'required',
            'passwordr' => 'required',
        ]);


        $User = new User();
            $User->name = $request['namer'];
            $User->email = $request['emailr'];
            $User->password = Hash::make($request['passwordr']);
        $User->save();
        
        // return $Paket;
        if($User){
            return response()->json(['error'=>false]);
        }else{
            return response()->json(['error'=>true]);
        }
    }

    public function logout()
    {
        $this->middleware('auth');
        Auth::logout();
        return redirect(route('login'));
    }



}
