<?php
namespace App\Http\Controllers\setups;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PackagesController extends Controller
{
    public function index(Request $request) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/package');
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $data['m_tittle'] = 'List Packages';
        $data['m_button'] = 'Add Package';
        $data['new_route'] = route('setup-package-create');
        $data['list'] = json_decode($response->body())->data;
        $data['thead'] = [
            ["value" => "id"],
            ["value" => "name"],
            ["value" => "code"],
            ["value" => "action"]
        ];
        $data['tbody'] = [];
        foreach ($data['list'] as $li) {
            $data['tbody'][] = [
                ["value" => $li->package_id],
                ["value" => $li->package_name],
                ["value" => $li->package_code],
                ["value" => "<div class='btn-group' role='group' aria-label=''>
                                <a href='" . url('setup/package/edit/' . $li->package_id) . "'><button type='button' class='btn btn-warning '> <i class='text-dark fa fa-pencil' aria-hidden='true'></i></button></a>
                                <a href='" . url('setup/package/delete/' . $li->package_id) . "'><button type='button' class='btn btn-danger text-dark'><i class='text-dark fa fa-trash' aria-hidden='true'></i></button></a>
                            </div>"
                ],
            ];
        }
        return view('models/m_setup', $data);
    }

    public function create() {
        return view('forms/f_setup', [
            'form_tittle' => 'Add New Package',
            'route' => route('setup-package-store'),
            'method' => 'POST',
            'button_text' => 'Add Package',
            'form_content' => [
                ["type" => "text", "name" => "package_name", "label" => "Package Name", "value" => ""],
                ["type" => "text", "name" => "package_code", "label" => "Package Code", "value" => ""],
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
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/setup/package', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-package');
        }
    }

    public function edit(Request $request, $id) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/package/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $package = json_decode($response->body())->data;

        $data['form_tittle'] = 'Edit Package Information';
        $data['route'] = route('setup-package-update', ['id' => $id]);
        $data['method'] = 'POST';
        $data['button_text'] = 'Edit Package';
        $data['form_content'] = [
            ["type" => "hidden", "name" => "package_id", "label" => "", "value" => $package->package_id],
            ["type" => "text", "name" => "package_name", "label" => "Package Name", "value" => $package->package_name],
            ["type" => "text", "name" => "package_code", "label" => "Package Code", "value" => $package->package_code],
        ];
        return view('forms/f_setup', $data);
    }

    public function update(Request $request, $id) {
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/setup/package/id', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-package-edit', ['id' => $id]);
        }
    }

    public function destroy($id) {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->delete(env('API_BASE_URL') . '/renbo/api/v1.0/setup/package/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-package');
        }
    }
}
