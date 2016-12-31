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

Route::get('/', ['middleware' => 'UserLoggedIn', function(Request $request){

	return view('app');

}]);

Route::get('/goods', ['middleware' => 'UserLoggedIn' ,function(){
	return Good::all();
}]);

Route::get('/login', function(){
	return view('login');
});

Route::post('/checkPassword', function(Request $request){

	if (\Hash::check($request['password'], '$2y$10$UNsD5dJ.5kjUFoOeW8t92.nmK3P789stR92j2uq1kIYoX2USbIsXi')){
		\Session::put('userCanLogin','ok');
		return redirect()->intended('/');
	}

	$request->session()->flash('message', 'wrong password');
	return redirect('/login');

});

Route::post('/uploadCsv', [
	'as'	=>	'uploadHandler',
	'uses'	=>	'uploadController@index'
]);