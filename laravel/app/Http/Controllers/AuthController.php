<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        $data['tittle'] = 'Porting - Dashboard';
        return view('auth/login',$data);
    }
    public function loginAct(request $request){
        $body['username'] = $request['username'];
        $body['password'] = $request['password']; 
        $response = Http::post(env('API_BASE_URL') . '/renbo/api/v1.0/login', $body);
        if($response->status()!==200){
            $err = json_decode($response->body());
            return redirect()->back()->withErrors($err->errors)->withInput();
        }
        $token = json_decode($response->body());
        $tkn = $token->accessToken;
        Session::put('token',$tkn);
        return redirect()->route('home');
    }
    public function home(request $request){
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/login/menu');
        if($response->status()!==200){
            return redirect()->route('login');
        }
        $data['menu'] = json_decode($response->body())->data;
       
        return view('menu_pages/v_menu',$data);
    }
}
