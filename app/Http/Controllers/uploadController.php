<?php

namespace App\Http\Controllers;
use \DB;
use League\Csv\Reader;
use Illuminate\Http\Request;
use App\Good;

class uploadController extends Controller
{
    public function index(Request $request){

    	// todo: error handling

    	// prepare filename for upload
    	$now = time();
		$filename = 'goods-' . $now . '.csv';
		$request->csv->storeAs('goods', $filename);

		// Begin Import Process

		// clear exisiting database
		DB::table('goods')->truncate(); 
	
	    // Get CSV content from goods.csv in storage
		$csv = Reader::createFromPath(storage_path() . '/app/goods/' . $filename );

		// Remove Headers
		$goods = collect($csv->setOffset(1)->fetchAll());

		// select only the fields that are needed and apply some formatting and casting ;
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
			return $good[8] > 0; // make sure to import only items with stock > 0
		});

		// Now Populate db with processed info

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

		$request->session()->flash('status', 'Ok');
		$request->session()->flash('message', $goods->count() . ' Records Successfully imported');

		return redirect('/');
    }
}
