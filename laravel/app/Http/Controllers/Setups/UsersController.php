<?php
namespace App\Http\Controllers\setups;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsersController extends Controller
{
    public function index(Request $request) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/user');
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $data['m_tittle'] = 'List Users';
        $data['m_button'] = 'Add Users';
        $data['new_route'] = route('setup-user-create');
        $data['list'] = json_decode($response->body())->data;
        $data['thead'] = [
            ["value"=> "id"],
            ["value"=> "username"],
            ["value"=> "email"],
            ["value"=> "role"],
            ["value"=> "action"],
        ];
        $data['tbody'] = [];

        foreach ($data['list'] as $li) {
            $data['tbody'][] = [
                ["value" => $li->user_id],
                ["value" => $li->user_name],
                ["value" => $li->user_email],
                ["value" => $li->role_name], 
                ["value" => "<div class='btn-group' role='group' aria-label=''>
                                <a href='" . url('setup/user/edit/' . $li->user_id) . "'><button type='button' class='btn btn-warning '> <i class='text-dark fa fa-pencil' aria-hidden='true'></i></button></a>
                                <a href='" . url('setup/user/delete/' . $li->user_id) . "'><button type='button' class='btn btn-danger text-dark'><i class='text-dark fa fa-trash' aria-hidden='true'></i></button></a>     
                            </div>"
                        ],
            ];
        }
        return view('models/m_setup', $data);
    }

    public function create() {
        return view('forms/f_setup', [
            'form_tittle' => 'Add New User',
            'route' => route('setup-user-store'),
            'method' => 'POST',
            'button_text' => 'Add User',
            'form_content' => [
                ["type" => "text", "name" => "user_name", "label" => "User Name", "value" => ""],
                ["type" => "email", "name" => "user_email", "label" => "User Email", "value" => ""],
                ["type" => "password", "name" => "user_password", "label" => "User Password", "value" => ""],
                ["type" => "select", "name" => "role_id", "label" => "Role", "value" => "", "options" => $this->getRoles()],
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
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/setup/user', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-user');
        }
    }

    public function edit(Request $request, $id) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/user/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $v =  json_decode($response->body())->data;

        $data['client'] = json_decode($response->body())->data;
        $model_1 = json_decode($response->body())->model->roles;
        $m_1 = [];
        foreach ($model_1 as $m1) {
            $m_1[] = [
                "value" => $m1->role_id,
                "label" => $m1->role_name
            ];
        }
        $data['form_tittle'] = 'Edit User Information';
        $data['route'] = route('setup-user-update',['id' => $id]);
        $data['method'] = 'POST';
        $data['button_text'] = 'Edit User';
        $data['form_content'] = [
            [
                "type"=> "hidden",
                "name"=> "user_id",
                "label"=> "",
                "value"=> $v[0]->user_id
            ],
            [
                "type"=> "text",
                "name"=> "user_name",
                "label"=> "Name",
                "value"=> $v[0]->user_name
            ],[
                "type"=> "email",
                "name"=> "user_email",
                "label"=> "Email",
                "value"=> $v[0]->user_email
            ],[
                "type"=> "password",
                "name"=> "user_password",
                "label"=> "New Password",
                "value"=> "1"
            ],[
                "type"=> "select",
                "name"=> "role_id",
                "label"=> "Select Role",
                "value"=> $v[0]->role_id,
                "options"=> $m_1
            ]
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
        $id = $body['user_id'];
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/setup/user/id', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-user-edit', ['id' => $id]);
        }
    }

    public function destroy($id) {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->delete(env('API_BASE_URL') . '/renbo/api/v1.0/setup/user/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-user');
        }
    }

    private function getRoles() {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/role');
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
}
