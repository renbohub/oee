<?php
namespace App\Http\Controllers\warehouses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index(Request $request) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/warehouse/products');
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $data['m_tittle'] = 'List Products';
        $data['m_button'] = 'Add Product';
        $data['new_route'] = route('warehouse-product-create');
        $data['list'] = json_decode($response->body())->data;
        $data['thead'] = [
            ["value" => "id"],
            ["value" => "product_name"],
            ["value" => "product_brand"],
            ["value" => "action"]
        ];
        $data['tbody'] = [];
        foreach ($data['list'] as $li) {
            $data['tbody'][] = [
                ["value" => $li->product_id],
                ["value" => $li->product_name],
                ["value" => $li->product_brand],
                ["value" => "<div class='btn-group' role='group' aria-label=''>
                                <a href='" . url('warehouse/product/edit/' . $li->product_id) . "'><button type='button' class='btn btn-warning '> <i class='text-dark fa fa-pencil' aria-hidden='true'></i></button></a>
                                <a href='" . url('warehouse/product/delete/' . $li->product_id) . "'><button type='button' class='btn btn-danger text-dark'><i class='text-dark fa fa-trash' aria-hidden='true'></i></button></a>
                            </div>"
                ],
            ];
        }
        return view('models/m_sales', $data);
    }

    public function create() {
        return view('forms/f_sales', [
            'form_tittle' => 'Add New Product',
            'route' => route('warehouse-product-store'),
            'method' => 'POST',
            'button_text' => 'Add Product',
            'form_content' => [
                ["type"=> "radio","name"=> "type_product_id","label"=> "Type Product","value"=> "1","options"=> [["value"=> "1", "label"=> "Service"],["value"=> "2", "label"=> "Material"]]],
                ["type"=> "text","name"=> "product_number","label"=> "Product Number","value"=> ""],
                ["type"=> "text","name"=> "product_name","label"=> "Product Name","value"=> ""],
                ["type"=> "text","name"=> "product_desc","label"=> "Product Desc","value"=> ""],
                ["type"=> "text","name"=> "product_brand","label"=> "Product Brand","value"=> ""],
                ["type"=> "number","name"=> "product_base_price","label"=> "Base Price","value"=> ""],
                ["type" => "select", "name" => "unit_id", "label" => "Product Unit", "value" => '', "options" => $this->getProductUnits()],
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
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/warehouse/product', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('warehouse-product');
        }
    }

    public function edit(Request $request, $id) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/warehouse/product/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $product = json_decode($response->body())->data[0];
        $data['form_tittle'] = 'Edit Product';
        $data['route'] = route('warehouse-product-update', ['id' => $id]);
        $data['method'] = 'POST';
        $data['button_text'] = 'Edit Product';
        $data['form_content'] = [
            ["type"=> "hidden","name"=> "product_id","label"=> "Hidden Field","value"=> $product->product_id],
            ["type"=> "radio","name"=> "type_product_id","label"=> "Type Product","value"=> "".$product->type_product_id."","options"=> [["value"=> "1", "label"=> "Service"],["value"=> "2", "label"=> "Material"]]],
            ["type"=> "text","name"=> "product_number","label"=> "Product Number","value"=> $product->product_number],
            ["type"=> "text","name"=> "product_name","label"=> "Product Name","value"=> $product->product_name],
            ["type"=> "text","name"=> "product_desc","label"=> "Product Desc","value"=> $product->product_desc],
            ["type"=> "text","name"=> "product_brand","label"=> "Product Brand","value"=> $product->product_brand],
            ["type"=> "number","name"=> "product_base_price","label"=> "Base Price","value"=> $product->product_base_price],
            ["type" => "select", "name" => "unit_id", "label" => "Product Unit", "value" => $product->unit_id, "options" => $this->getProductUnits()],
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
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/warehouse/product/id?id=' . $id, $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('warehouse-product-edit', ['id' => $id]);
        }
    }

    public function destroy($id) {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->delete(env('API_BASE_URL') . '/renbo/api/v1.0/warehouse/product/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('warehouse-product');
        }
    }

    private function getApps() {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/app');
        $apps = [];
        if ($response->status() == 200) {
            $apps = json_decode($response->body())->data;
        }
        $options = [];
        foreach ($apps as $app) {
            $options[] = ["value" => $app->app_id, "label" => $app->app_name];
        }
        return $options;
    }

    private function getPackages() {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/package');
        $packages = [];
        if ($response->status() == 200) {
            $packages = json_decode($response->body())->data;
        }
        $options = [];
        foreach ($packages as $package) {
            $options[] = ["value" => $package->package_id, "label" => $package->package_name];
        }
        return $options;
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
        $options = [];
        foreach ($roles as $roles) {
            $options[] = ["value" => $roles->unit_id, "label" => $roles->unit_desc];
        }
        return $options;
    }

}
