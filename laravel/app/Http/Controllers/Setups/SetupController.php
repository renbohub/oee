<?php

namespace App\Http\Controllers\setups;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SetupController extends Controller
{
    public function home(request $request){
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/client');
        if($response->status()!==200){
            return redirect()->route('login');
        }
        $data['client'] = json_decode($response->body())->data;
        return view('setup_pages/v_info',$data);
    }
    public function CompanyEdit(request $request){
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/client');
        if($response->status()!==200){
            return redirect()->route('login');
        }
        $v =  json_decode($response->body())->data;
        $data['client'] = json_decode($response->body())->data;

        $data['form_tittle'] = 'Edit Company Information';
        $data['route'] = route('company-edit-act');
        $data['method'] = 'POST';
        $data['button_text'] = 'Edit';
        $data['form_content'] = [
            [
                "type"=> "text",
                "name"=> "client_name",
                "label"=> "Company ID",
                "value"=> $v->client_name
            ],[
                "type"=> "text",
                "name"=> "client_company",
                "label"=> "Company Name",
                "value"=> $v->client_company
            ],[
                "type"=> "email",
                "name"=> "client_email",
                "label"=> "Company Email",
                "value"=> $v->client_email
            ],[
                "type"=> "text",
                "name"=> "client_allias",
                "label"=> "Company Shortname",
                "value"=> $v->client_allias
            ],[
                "type"=> "textarea",
                "name"=> "client_address",
                "label"=> "Client Address",
                "value"=> $v->client_address
            ],[
                "type"=> "image",
                "name"=> "image",
                "label"=> "",
                "value"=> "data:image/jpeg;base64,".$v->client_main_logo.""
            ],[
                "type"=> "file",
                "name"=> "client_main_logo",
                "label"=> "Edit Main Logo",
                "value"=> ""
            ],[
                "type"=> "image",
                "name"=> "image",
                "label"=> "",
                "value"=> "data:image/jpeg;base64,".$v->client_small_logo.""
            ],[
                "type"=> "file",
                "name"=> "client_small_logo",
                "label"=> "Edit Small Logo",
                "value"=> ""
            ]
        ];
        return view('forms/f_setup',$data);
    }
    public function CompanyEditAct(request $request){
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        if (isset($body['client_main_logo'])) {
            $request->validate([
                'client_main_logo' => 'required|file|mimes:jpg,jpeg,png',
            ]);
    
            $file = $request->file('client_main_logo');
            $fileData = file_get_contents($file->getRealPath());
            $base64FileData = base64_encode($fileData);
            $body['client_main_logo'] = $base64FileData;
        }
    
        // Handle client_small_logo
        if (isset($body['client_small_logo'])) {
            $request->validate([
                'client_small_logo' => 'required|file|mimes:jpg,jpeg,png',
            ]);
    
            $file1 = $request->file('client_small_logo');
            $fileData1 = file_get_contents($file1->getRealPath());
            $base64FileData1 = base64_encode($fileData1);
            $body['client_small_logo'] = $base64FileData1;
        }
    
        // Log the body for debugging purposes
        
        
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/setup/client',$body);
        if($response->status()!==200){
            return redirect()->route('login');
        }else{
            return redirect()->route('company-edit');
        }

       
    }
    public function User(request $request){
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/user');
        if($response->status()!==200){
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

        // Loop through each item in the list and create a row
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
                        ],  // You might want to change this if it's supposed to be an action
            ];
        }
        return view('models/m_setup',$data);
    }
    public function UserEdit(request $request,$id){
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/user/id?id='.$id.'');
        if($response->status()!==200){
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
        $data['route'] = route('setup-user-edit-act');
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
        return view('forms/f_setup',$data);
    }
    public function UserEditAct(request $request){
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();    
        $id = $body['user_id'];
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/setup/user/id',$body);
        if($response->status()!==200){
            return redirect()->route('login');
        }else{
            return redirect()->route('setup-user-edit', ['id' => $id]);
        }
    }
    public function UserCreate(request $request){
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/user/id?id=1');
        if($response->status()!==200){
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
        $data['form_tittle'] = 'Create User';
        $data['route'] = route('setup-user-create-act');
        $data['method'] = 'POST';
        $data['button_text'] = 'Create User';
        $data['form_content'] = [
            [
                "type"=> "hidden",
                "name"=> "user_id",
                "label"=> "",
                "value"=> ""
            ],
            [
                "type"=> "text",
                "name"=> "user_name",
                "label"=> "Name",
                "value"=> ""
            ],[
                "type"=> "email",
                "name"=> "user_email",
                "label"=> "Email",
                "value"=> ""
            ],[
                "type"=> "password",
                "name"=> "user_password",
                "label"=> "New Password",
                "value"=> ""
            ],[
                "type"=> "select",
                "name"=> "role_id",
                "label"=> "Select Role",
                "value"=> "",
                "options"=> $m_1
            ]
        ];
        return view('forms/f_setup',$data); 
    }
    public function UserCreateAct(request $request){  
       
    }
    public function UserDelete(request $request){
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        if (isset($body['client_main_logo'])) {
            $request->validate([
                'client_main_logo' => 'required|file|mimes:jpg,jpeg,png',
            ]);
    
            $file = $request->file('client_main_logo');
            $fileData = file_get_contents($file->getRealPath());
            $base64FileData = base64_encode($fileData);
            $body['client_main_logo'] = $base64FileData;
        }
    
        // Handle client_small_logo
        if (isset($body['client_small_logo'])) {
            $request->validate([
                'client_small_logo' => 'required|file|mimes:jpg,jpeg,png',
            ]);
    
            $file1 = $request->file('client_small_logo');
            $fileData1 = file_get_contents($file1->getRealPath());
            $base64FileData1 = base64_encode($fileData1);
            $body['client_small_logo'] = $base64FileData1;
        }
    
        // Log the body for debugging purposes
        
        
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/setup/client',$body);
        if($response->status()!==200){
            return redirect()->route('login');
        }else{
            return redirect()->route('company-edit');
        }

       
    }
    public function UserDeleteAct(request $request){
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $body = $request->all();
        if (isset($body['client_main_logo'])) {
            $request->validate([
                'client_main_logo' => 'required|file|mimes:jpg,jpeg,png',
            ]);
    
            $file = $request->file('client_main_logo');
            $fileData = file_get_contents($file->getRealPath());
            $base64FileData = base64_encode($fileData);
            $body['client_main_logo'] = $base64FileData;
        }
    
        // Handle client_small_logo
        if (isset($body['client_small_logo'])) {
            $request->validate([
                'client_small_logo' => 'required|file|mimes:jpg,jpeg,png',
            ]);
    
            $file1 = $request->file('client_small_logo');
            $fileData1 = file_get_contents($file1->getRealPath());
            $base64FileData1 = base64_encode($fileData1);
            $body['client_small_logo'] = $base64FileData1;
        }
    
        // Log the body for debugging purposes
        
        
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/setup/client',$body);
        if($response->status()!==200){
            return redirect()->route('login');
        }else{
            return redirect()->route('company-edit');
        }

       
    }
}

