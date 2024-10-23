<?php
namespace App\Http\Controllers\setups;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RoutePermissionsController extends Controller
{
    public function index(Request $request) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/route_permissions');
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $data['m_tittle'] = 'List Route Permissions';
        $data['m_button'] = 'Add Route Permission';
        $data['new_route'] = route('setup-route-permission-create');
        $data['list'] = json_decode($response->body())->data;
        $data['thead'] = [
            ["value" => "id"],
            ["value" => "role"],
            ["value" => "route"],
            ["value" => "action"]
        ];
        $data['tbody'] = [];
        foreach ($data['list'] as $li) {
            $data['tbody'][] = [
                ["value" => $li->route_permission_id],
                ["value" => $li->role_name],
                ["value" => $li->route_name],
                ["value" => "<div class='btn-group' role='group' aria-label=''>
                                <a href='" . url('setup/route_permission/edit/' . $li->route_permission_id) . "'><button type='button' class='btn btn-warning '> <i class='text-dark fa fa-pencil' aria-hidden='true'></i></button></a>
                                <a href='" . url('setup/route_permission/delete/' . $li->route_permission_id) . "'><button type='button' class='btn btn-danger text-dark'><i class='text-dark fa fa-trash' aria-hidden='true'></i></button></a>
                            </div>"
                ],
            ];
        }
        return view('models/m_setup', $data);
    }

    public function create() {
        return view('forms/f_setup', [
            'form_tittle' => 'Add New Route Permission',
            'route' => route('setup-route-permission-store'),
            'method' => 'POST',
            'button_text' => 'Add Route Permission',
            'form_content' => [
                ["type" => "select", "name" => "role_id", "label" => "Role", "value" => "", "options" => $this->getRoles()],
                ["type" => "select", "name" => "route_id", "label" => "Route", "value" => "", "options" => $this->getRoutes()],
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
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/setup/route_permissions', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-route-permission');
        }
    }

    public function edit(Request $request, $id) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/route_permissions/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $route_permission = json_decode($response->body())->data;

        $data['form_tittle'] = 'Edit Route Permission';
        $data['route'] = route('setup-route-permission-update', ['id' => $id]);
        $data['method'] = 'POST';
        $data['button_text'] = 'Edit Route Permission';
        $data['form_content'] = [
            ["type" => "hidden", "name" => "route_permission_id", "label" => "", "value" => $route_permission->route_permission_id],
            ["type" => "select", "name" => "role_id", "label" => "Role", "value" => $route_permission->role_id, "options" => $this->getRoles()],
            ["type" => "select", "name" => "route_id", "label" => "Route", "value" => $route_permission->route_id, "options" => $this->getRoutes()],
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
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/setup/route_permissions/id', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-route-permission-edit', ['id' => $id]);
        }
    }

    public function destroy($id) {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->delete(env('API_BASE_URL') . '/renbo/api/v1.0/setup/route_permissions/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-route-permission');
        }
    }

    private function getRoles() {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/roles');
        $roles = [];
        if ($response->status() == 200) {
            $roles = json_decode($response->body())->data;
        }
        $options = [];
        foreach ($roles as $role) {
            $options[] = ["value" => $role->role_id, "label" => $role->role_name];
        }
        return $options;
    }

    private function getRoutes() {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/routes');
        $routes = [];
        if ($response->status() == 200) {
            $routes = json_decode($response->body())->data;
        }
        $options = [];
        foreach ($routes as $route) {
            $options[] = ["value" => $route->route_id, "label" => $route->route_name];
        }
        return $options;
    }
}
