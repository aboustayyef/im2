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
use League\Csv\Reader;
use App\Good;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/goods', function(){
	return Good::all();
});

Route::post('/', function(Request $request){

	if (\Hash::check($request['password'], '$2y$10$UNsD5dJ.5kjUFoOeW8t92.nmK3P789stR92j2uq1kIYoX2USbIsXi')){
		return view('app');
	}

	return response('forbidden', 403);

});

Route::post('/uploadCsv', function(Request $request){

	$now = time();
	$filename = 'goods-' . $now . '.csv';
	$request->csv->storeAs('goods', $filename);

	// Begin Import Process

		// clear database
		DB::table('goods')->truncate(); 
	
	    // Get CSV content from goods.csv in storage
		$csv = Reader::createFromPath(storage_path() . '/app/goods/' . $filename );

		// Remove Headers
		$goods = collect($csv->setOffset(1)->fetchAll());

		// take only info I need and make sure to import only items with stock > 0;
		$goods = $goods->map(function($good){
			return [
				$good[0], // Code
				$good[1], //  Name
				$good[2], //  Brand
				$good[3], //  Description
				$good[5], //  Supplier
				round((float) $good[6],3), // Price Ex
				round((float) $good[7],3), // Price in
				round((float) $good[8],3), // Value
				(int) $good[12], // Stock
				];
		})->filter(function($good){
			return $good[8] > 0;
		});

		// Fill info in db
		$goods->each(function($item, $key){
			$record = new Good;
            $record->Code = $item[0];
            $record->Name = $item[1];
            $record->Brand = $item[2];
            $record->Description = $item[3];
            $record->Supplier = $item[4];
            $record->PriceEx = $item[5];
            $record->PriceIn = $item[6];
            $record->Value = $item[7];
            $record->Stock = $item[8];
	        $record->save();
		});
		return redirect('/');
});