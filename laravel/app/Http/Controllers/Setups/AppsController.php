<?php
namespace App\Http\Controller\setups;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppsController extends Controller
{
    public function index(Request $request) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/apps');
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $data['m_tittle'] = 'List Apps';
        $data['m_button'] = 'Add Apps';
        $data['new_route'] = route('setup-app-create');
        $data['list'] = json_decode($response->body())->data;
        $data['thead'] = [
            ["value" => "id"],
            ["value" => "name"],
            ["value" => "url"],
            ["value" => "code"],
            ["value" => "action"]
        ];
        $data['tbody'] = [];
        foreach ($data['list'] as $li) {
            $data['tbody'][] = [
                ["value" => $li->app_id],
                ["value" => $li->app_name],
                ["value" => $li->app_url],
                ["value" => $li->app_code],
                ["value" => "<div class='btn-group' role='group' aria-label=''>
                                <a href='" . url('setup/app/edit/' . $li->app_id) . "'><button type='button' class='btn btn-warning '> <i class='text-dark fa fa-pencil' aria-hidden='true'></i></button></a>
                                <a href='" . url('setup/app/delete/' . $li->app_id) . "'><button type='button' class='btn btn-danger text-dark'><i class='text-dark fa fa-trash' aria-hidden='true'></i></button></a>
                            </div>"
                ],
            ];
        }
        return view('models/m_setup', $data);
    }

    public function create() {
        return view('forms/f_setup', [
            'form_tittle' => 'Add New App',
            'route' => route('setup-app-store'),
            'method' => 'POST',
            'button_text' => 'Add App',
            'form_content' => [
                ["type" => "text", "name" => "app_name", "label" => "App Name", "value" => ""],
                ["type" => "text", "name" => "app_url", "label" => "App URL", "value" => ""],
                ["type" => "text", "name" => "app_code", "label" => "App Code", "value" => ""],
                ["type" => "file", "name" => "app_logo", "label" => "App Logo", "value" => ""],
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
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/setup/apps', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-app');
        }
    }

    public function edit(Request $request, $id) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/apps/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $app = json_decode($response->body())->data;

        $data['form_tittle'] = 'Edit App Information';
        $data['route'] = route('setup-app-update', ['id' => $id]);
        $data['method'] = 'POST';
        $data['button_text'] = 'Edit App';
        $data['form_content'] = [
            ["type" => "hidden", "name" => "app_id", "label" => "", "value" => $app->app_id],
            ["type" => "text", "name" => "app_name", "label" => "App Name", "value" => $app->app_name],
            ["type" => "text", "name" => "app_url", "label" => "App URL", "value" => $app->app_url],
            ["type" => "text", "name" => "app_code", "label" => "App Code", "value" => $app->app_code],
            ["type" => "file", "name" => "app_logo", "label" => "App Logo", "value" => $app->app_logo],
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
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/setup/apps/id', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-app-edit', ['id' => $id]);
        }
    }

    public function destroy($id) {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->delete(env('API_BASE_URL') . '/renbo/api/v1.0/setup/apps/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-app');
        }
    }
}
