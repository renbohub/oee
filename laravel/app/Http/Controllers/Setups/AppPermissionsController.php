<?php
namespace App\Http\Controllers\setups;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppPermissionsController extends Controller
{
    public function index(Request $request) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/app_permission');
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $data['m_tittle'] = 'List App Permissions';
        $data['m_button'] = 'Add App Permission';
        $data['new_route'] = route('setup-app-permission-create');
        $data['list'] = json_decode($response->body())->data;
        $data['thead'] = [
            ["value" => "id"],
            ["value" => "app"],
            ["value" => "package"],
            ["value" => "action"]
        ];
        $data['tbody'] = [];
        foreach ($data['list'] as $li) {
            $data['tbody'][] = [
                ["value" => $li->app_permission_id],
                ["value" => $li->app_name],
                ["value" => $li->package_name],
                ["value" => "<div class='btn-group' role='group' aria-label=''>
                                <a href='" . url('setup/app_permission/edit/' . $li->app_permission_id) . "'><button type='button' class='btn btn-warning '> <i class='text-dark fa fa-pencil' aria-hidden='true'></i></button></a>
                                <a href='" . url('setup/app_permission/delete/' . $li->app_permission_id) . "'><button type='button' class='btn btn-danger text-dark'><i class='text-dark fa fa-trash' aria-hidden='true'></i></button></a>
                            </div>"
                ],
            ];
        }
        return view('models/m_setup', $data);
    }

    public function create() {
        return view('forms/f_setup', [
            'form_tittle' => 'Add New App Permission',
            'route' => route('setup-app-permission-store'),
            'method' => 'POST',
            'button_text' => 'Add App Permission',
            'form_content' => [
                ["type" => "select", "name" => "app_id", "label" => "App", "value" => "", "options" => $this->getApps()],
                ["type" => "select", "name" => "package_id", "label" => "Package", "value" => "", "options" => $this->getPackages()],
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
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/setup/app_permission/create', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-app-permission');
        }
    }

    public function edit(Request $request, $id) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/app_permission/edit/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $app_permission = json_decode($response->body())->data;

        $data['form_tittle'] = 'Edit App Permission';
        $data['route'] = route('setup-app-permission-update', ['id' => $id]);
        $data['method'] = 'POST';
        $data['button_text'] = 'Edit App Permission';
        $data['form_content'] = [
            ["type" => "hidden", "name" => "app_permission_id", "label" => "", "value" => $app_permission->app_permission_id],
            ["type" => "select", "name" => "app_id", "label" => "App", "value" => $app_permission->app_id, "options" => $this->getApps()],
            ["type" => "select", "name" => "package_id", "label" => "Package", "value" => $app_permission->package_id, "options" => $this->getPackages()],
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
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/setup/app_permission/edit/id?id=' . $id, $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-app-permission-edit', ['id' => $id]);
        }
    }

    public function destroy($id) {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->delete(env('API_BASE_URL') . '/renbo/api/v1.0/setup/app_permission/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-app-permission');
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
}
