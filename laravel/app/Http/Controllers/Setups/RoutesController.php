<?php
namespace App\Http\Controllers\setups;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RoutesController extends Controller
{
    public function index(Request $request) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/route');
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $data['m_tittle'] = 'List Routes';
        $data['m_button'] = 'Add Route';
        $data['new_route'] = route('setup-route-create');
        $data['list'] = json_decode($response->body())->data;
        $data['thead'] = [
            ["value" => "id"],
            ["value" => "name"],
            ["value" => "url"],
            ["value" => "action"]
        ];
        $data['tbody'] = [];
        foreach ($data['list'] as $li) {
            $data['tbody'][] = [
                ["value" => $li->route_id],
                ["value" => $li->route_name],
                ["value" => $li->route_url],
                ["value" => "<div class='btn-group' role='group' aria-label=''>
                                <a href='" . url('setup/route/edit/' . $li->route_id) . "'><button type='button' class='btn btn-warning '> <i class='text-dark fa fa-pencil' aria-hidden='true'></i></button></a>
                                <a href='" . url('setup/route/delete/' . $li->route_id) . "'><button type='button' class='btn btn-danger text-dark'><i class='text-dark fa fa-trash' aria-hidden='true'></i></button></a>
                            </div>"
                ],
            ];
        }
        return view('models/m_setup', $data);
    }

    public function create() {
        return view('forms/f_setup', [
            'form_tittle' => 'Add New Route',
            'route' => route('setup-route-store'),
            'method' => 'POST',
            'button_text' => 'Add Route',
            'form_content' => [
                ["type" => "text", "name" => "route_name", "label" => "Route Name", "value" => ""],
                ["type" => "text", "name" => "route_url", "label" => "Route URL", "value" => ""],
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
        $response = Http::withHeaders($headers)->post(env('API_BASE_URL') . '/renbo/api/v1.0/setup/route', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-route');
        }
    }

    public function edit(Request $request, $id) {
        $data['tittle'] = 'Porting - Dashboard';
        $session = $request->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->get(env('API_BASE_URL') . '/renbo/api/v1.0/setup/route/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        }
        $route = json_decode($response->body())->data;

        $data['form_tittle'] = 'Edit Route Information';
        $data['route'] = route('setup-route-update', ['id' => $id]);
        $data['method'] = 'POST';
        $data['button_text'] = 'Edit Route';
        $data['form_content'] = [
            ["type" => "hidden", "name" => "route_id", "label" => "", "value" => $route->route_id],
            ["type" => "text", "name" => "route_name", "label" => "Route Name", "value" => $route->route_name],
            ["type" => "text", "name" => "route_url", "label" => "Route URL", "value" => $route->route_url],
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
        $response = Http::withHeaders($headers)->put(env('API_BASE_URL') . '/renbo/api/v1.0/setup/route/id', $body);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-route-edit', ['id' => $id]);
        }
    }

    public function destroy($id) {
        $session = request()->session()->all();
        $headers = [
            'Content-Type' => 'application/json',
            'x-access-token' => $session['token']
        ];
        $response = Http::withHeaders($headers)->delete(env('API_BASE_URL') . '/renbo/api/v1.0/setup/route/id?id=' . $id);
        if ($response->status() !== 200) {
            return redirect()->route('login');
        } else {
            return redirect()->route('setup-route');
        }
    }
}
