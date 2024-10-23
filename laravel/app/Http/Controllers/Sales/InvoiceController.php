<?php
namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InvoiceController extends Controller
{
    public function home(Request $request) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $data['customer'] = $this->getRoles();
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/user');
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        return view('sales_pages.v_invoice', $data);
    }
    public function data(Request $request) {
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/sales/invoice', $body);
        if ($response->status() == 200) {
            $data = json_decode($response->body());
        }else{
            $data = 'not found';
        };
        return $data;
    } 
    public function post(Request $request) {
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/sales/invoice', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('sales-invoice');
        }
    }
    public function edit(Request $request , $token) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $data['customer'] = $this->getRoles();
        $data['list_options'] = $this->getProducts();
        $data['list_options1'] = $this->getProductUnits();
        $data['sales'] = $this->getSales();
        $data['tops'] = $this->getTops();
        $data['accounts'] = $this->getAccounts();
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/sales/invoice/edit/?token='.$token);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $data['header'] = json_decode($response->body())->data[0];
        $sub = json_decode($response->body())->sub;
        $data['role'] = json_decode($response->body())->role;
        $data['sub_length'] = count($sub);
        $data['sub'] = $sub;
      
        return view('sales_pages.v_invoice_edit', $data);
    }
    public function updateStatus(Request $request) {
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/sales/invoice/status', $body);
        if ($response->status() == 200) {
            $data = json_decode($response->body());
        }else{
            $data = 'not found';
        };
        return $data;
    } 
    public function exportPdf(Request $request,$token) {
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/sales/invoice/export?token='.$token);
        
        if ($response->status() == 200) {
            $data = $response->body();
            return response($data, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="output.pdf"');
        }else{
            $data = 'not found';
        };
        return $data;
    } 
    public function editHeader(Request $request) {
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/sales/invoice/header', $body);
        if ($response->status() == 200) {
            $data = json_decode($response->body());
        }else{
            $data = 'not found';
        };
        return $data;
    } 
    private function getRoles() {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/sales/customers');
        if ($response->status() == 200) {
            $roles = json_decode($response->body())->data;
        }
        
        return $roles;
    }
    private function getProducts() {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/warehouse/products');
        if ($response->status() == 200) {
            $roles = json_decode($response->body())->data;
        }
        
        return $roles;
    }
    private function getProductUnits() {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/warehouse/units');
        if ($response->status() == 200) {
            $roles = json_decode($response->body())->data;
        }
        
        return $roles;
    }
    private function getSales() {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/user');
        if ($response->status() == 200) {
            $roles = json_decode($response->body())->data;
        }
        
        return $roles;
    }
    private function getTops() {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/accounting/tops');
        if ($response->status() == 200) {
            $roles = json_decode($response->body())->data;
        }
        
        return $roles;
    }
    private function getAccounts() {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/accounting/accounts');
        if ($response->status() == 200) {
            $roles = json_decode($response->body())->data;
        }
        
        return $roles;
    }
    
}
