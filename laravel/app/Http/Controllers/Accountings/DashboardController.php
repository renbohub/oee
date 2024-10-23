<?php
namespace App\Http\Controllers\Accountings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/sales/dashboard', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $data['chart'] = json_decode($response->body())->data;
        return view('accounting_pages/v_dashboard', $data);
    }
    public function indexData(Request $request) {
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/sales/dashboard', $body);
        if ($response->status() == 200) {
            $data = json_decode($response->body());
        }else{
            $data = 'not found';
        };
        return $data;
    } 
}
