<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Status;
use App\User;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('status');
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);

        $id_user=Auth::user()->id;


        $Status = new Status();
            $Status->id_user = $id_user;
            $Status->isi = $request['status'];
        $Status->save();
        
        // return $Paket;
        if($Status){
            return response()->json(['error'=>false]);
        }else{
            return response()->json(['error'=>true]);
        }
    }

    public function getCurrentUser()
    {
        return Auth::user();
    }

    public function datas()
    {
        $data=Status::select('statuses.*', 'users.name')
                        ->join('users', 'statuses.id_user', '=', 'users.id')
                        ->orderBy('updated_at','DESC')->get();
                    
        return response()->json($data);
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'name' => 'required',
        ]);
        $id_user=Auth::user()->id;

        if(isset($request['password'])){
            $Gante = User::where('id', $id_user)->update(array(
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ));
        }else{
            $Gante =  User::where('id', $id_user)->update(array(
                'name' => $request['name'],
                'email' => $request['email'],
            ));

        }

        if($Gante){
            return response()->json(['error'=>false]);
        }else{
            return response()->json(['error'=>true]);
        }

    }

    public function uploadImage(Request $request)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $id_user=Auth::user()->id;
        $imageName = $id_user.'-'.time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path(), $imageName);

        //update db
        $Gante =  User::where('id', $id_user)->update(array(
            'image' => $imageName,
        ));


        return response()->json(['error'=>false, 'filename' => $imageName]);
    }
    
}
