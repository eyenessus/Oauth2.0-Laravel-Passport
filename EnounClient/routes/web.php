<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redirect', function (Request $request) {
    $request->session()->put('state', $state = Str::random(40));
    $query = http_build_query([
        'client_id' => env('CLIENT_ID'),
        'redirect_uri' => env('REDIRECT_URL'),
        'response_type' => 'code',
        'scope' => '',
        'state' => $state,
        // 'prompt' => '', // "none", "consent", or "login"
    ]);
 
    return redirect('http://localhost:8000/oauth/authorize?'.$query);
})->name('login');


Route::get('/callback', function (Request $request) {
    // $state = $request->session()->pull('state');
    // dd($request->session());
    // throw_unless(
    //     strlen($state) > 0 && $state === $request->state,
    //     InvalidArgumentException::class,
    //     'Invalid state value.'
    // );
 
    $response = Http::asForm()->post(env('API_URL').'oauth/token', [
        'grant_type' => 'authorization_code',
        'client_id' => env('CLIENT_ID'),
        'client_secret' => env('CLIENT_SECRET'),
        'redirect_uri' => env('REDIRECT_URL'),
        'code' => $request->code,
    ]);
    dd($response->json());
    return $response->json();
});
