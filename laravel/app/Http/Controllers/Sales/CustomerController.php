<?php
namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    public function index(Request $request) {
        $data['title'] = 'Customer - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/sales/customers');
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $data['m_tittle'] = 'List Customers';
        $data['m_button'] = 'Add Customer';
        $data['new_route'] = route('sales-customer-create');
        $data['list'] = json_decode($response->body())->data;
        $data['thead'] = [
            ["value"=> "ID"],
            ["value"=> "Name"],
            ["value"=> "Company"],
            ["value"=> "Email"],
            ["value"=> "Start Date"],
            ["value"=> "Address"],
            ["value"=> "Alias"],
            ["value"=> "Number"],
            ["value"=> "Action"],
        ];
        $data['tbody'] = [];

        foreach ($data['list'] as $li) {
            $data['tbody'][] = [
                ["value" => $li->customer_id],
                ["value" => $li->customer_name],
                ["value" => $li->customer_company],
                ["value" => $li->customer_email],
                ["value" => $li->customer_start],
                ["value" => $li->customer_address],
                ["value" => $li->customer_allias],
                ["value" => $li->customer_number],
                ["value" => "<div class='btn-group' role='group' aria-label=''>
                                <a href='" . url('sales/customer/edit/' . $li->customer_id) . "'><button type='button' class='btn btn-warning '> <i class='text-dark fa fa-pencil' aria-hidden='true'></i></button></a>
                                <a href='" . url('sales/customer/delete/' . $li->customer_id) . "'><button type='button' class='btn btn-danger text-dark'><i class='text-dark fa fa-trash' aria-hidden='true'></i></button></a>     
                            </div>"
                        ],
            ];
        }
        return view('models/m_sales', $data);
    }

    public function create() {
        return view('forms/f_sales', [
            'form_tittle' => 'Add New Customer',
            'route' => route('sales-customer-store'),
            'method' => 'POST',
            'button_text' => 'Add Customer',
            'form_content' => [
                ["type" => "text", "name" => "customer_name", "label" => "Customer Name", "value" => ""],
                ["type" => "text", "name" => "customer_company", "label" => "Company", "value" => ""],
                ["type" => "email", "name" => "customer_email", "label" => "Customer Email", "value" => ""],
                ["type" => "date", "name" => "customer_start", "label" => "Start Date", "value" => ""],
                ["type" => "textarea", "name" => "customer_address", "label" => "Address", "value" => ""],
                ["type" => "text", "name" => "customer_allias", "label" => "Alias", "value" => ""],
                ["type" => "text", "name" => "customer_number", "label" => "Number", "value" => ""],
                ["type" => "hidden", "name" => "client_id", "label" => "Client ID", "value" => ""],
            ]
        ]);
    }

    public function store(Request $request) {
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/sales/customers', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('sales-customer');
        }
    }

    public function edit(Request $request, $id) {
        $data['title'] = 'Customer - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/sales/customers/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $customer = json_decode($response->body())->data[0];
        
        $data['form_tittle'] = 'Edit Customer Information';
        $data['route'] = route('sales-customer-update', ['id' => $id]);
        $data['method'] = 'POST';
        $data['button_text'] = 'Edit Customer';
        $data['form_content'] = [
            ["type" => "hidden", "name" => "customer_id", "label" => "", "value" => $customer->customer_id],
            ["type" => "text", "name" => "customer_name", "label" => "Name", "value" => $customer->customer_name],
            ["type" => "text", "name" => "customer_company", "label" => "Company", "value" => $customer->customer_company],
            ["type" => "email", "name" => "customer_email", "label" => "Email", "value" => $customer->customer_email],
            ["type" => "textarea", "name" => "customer_address", "label" => "Address", "value" => $customer->customer_address],
            ["type" => "text", "name" => "customer_allias", "label" => "Alias", "value" => $customer->customer_allias],
            ["type" => "text", "name" => "customer_number", "label" => "Number", "value" => $customer->customer_number],
        ];
        return view('forms/f_sales', $data);
    }

    public function update(Request $request, $id) {
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/sales/customers/id?id=' . $id, $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('sales-customer-edit', ['id' => $id]);
        }
    }

    public function destroy($id) {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->delete(env('API_BASE_URL') . '/renbo/api/v1.0/sales/customers/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('sales-customer');
        }
    }
}
