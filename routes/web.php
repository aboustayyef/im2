<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use App\Good;

Route::get('/', function(Request $request){

	if ($request->session()->has('userCanLogin')) {
		return view('app');
	}
	
	return view('login')->with('request', $request);;
});

Route::get('/goods', function(){
	return Good::all();
});

Route::post('/checkPassword', function(Request $request){

	if (\Hash::check($request['password'], '$2y$10$UNsD5dJ.5kjUFoOeW8t92.nmK3P789stR92j2uq1kIYoX2USbIsXi')){
		$request->session()->put('userCanLogin','ok');
		return redirect('/');
	}

	$request->session()->flash('message', 'wrong password');
	return view('login')->with('request', $request);

});

Route::post('/uploadCsv', [
	'as'	=>	'uploadHandler',
	'uses'	=>	'uploadController@index'
]);