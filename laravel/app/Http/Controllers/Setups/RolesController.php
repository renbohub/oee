<?php
namespace App\Http\Controllers\setups;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RolesController extends Controller
{
    public function index(Request $request) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/role');
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $data['m_tittle'] = 'List Roles';
        $data['m_button'] = 'Add Role';
        $data['new_route'] = route('setup-role-create');
        $data['list'] = json_decode($response->body())->data;
        $data['thead'] = [
            ["value" => "id"],
            ["value" => "name"],
            ["value" => "description"],
            ["value" => "action"]
        ];
        $data['tbody'] = [];
        foreach ($data['list'] as $li) {
            $data['tbody'][] = [
                ["value" => $li->role_id],
                ["value" => $li->role_name],
                ["value" => $li->role_desc],
                ["value" => "<div class='btn-group' role='group' aria-label=''>
                                <a href='" . url('setup/role/edit/' . $li->role_id) . "'><button type='button' class='btn btn-warning '> <i class='text-dark fa fa-pencil' aria-hidden='true'></i></button></a>
                                <a href='" . url('setup/role/delete/' . $li->role_id) . "'><button type='button' class='btn btn-danger text-dark'><i class='text-dark fa fa-trash' aria-hidden='true'></i></button></a>
                            </div>"
                ],
            ];
        }
        return view('models/m_setup', $data);
    }

    public function create() {
        return view('forms/f_setup', [
            'form_tittle' => 'Add New Role',
            'route' => route('setup-role-store'),
            'method' => 'POST',
            'button_text' => 'Add Role',
            'form_content' => [
                ["type" => "text", "name" => "role_name", "label" => "Role Name", "value" => ""],
                ["type" => "text", "name" => "role_desc", "label" => "Role Description", "value" => ""],
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
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/setup/role', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-role');
        }
    }

    public function edit(Request $request, $id) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/role/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $role = json_decode($response->body())->data;

        $data['form_tittle'] = 'Edit Role Information';
        $data['route'] = route('setup-role-update', ['id' => $id]);
        $data['method'] = 'POST';
        $data['button_text'] = 'Edit Role';
        $data['form_content'] = [
            ["type" => "hidden", "name" => "role_id", "label" => "", "value" => $role->role_id],
            ["type" => "text", "name" => "role_name", "label" => "Role Name", "value" => $role->role_name],
            ["type" => "text", "name" => "role_desc", "label" => "Role Description", "value" => $role->role_desc],
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
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/setup/role/id', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-role-edit', ['id' => $id]);
        }
    }

    public function destroy($id) {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->delete(env('API_BASE_URL') . '/renbo/api/v1.0/setup/role/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-role');
        }
    }
}
