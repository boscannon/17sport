<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product as crudModel;
use DataTables;
use Exception;
use DB;

use App\Imports\StockShoplineImport;
use Maatwebsite\Excel\Facades\Excel;

class StockShoplineController extends Controller
{
    public function __construct() {
        $this->name = 'stock_details';
        $this->view = 'backend.'.$this->name;
        $this->rules = [
            'file' => ['required', 'file'],         
        ];
        $this->messages = [];
        $this->attributes = [
            'file' => __("backend.{$this->name}.shopline_excel"),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $this->authorize('create '.$this->name);
        $validatedData = $request->validate($this->rules, $this->messages, $this->attributes);

        try{
            DB::beginTransaction();
            
            Excel::import(new StockShoplineImport, $validatedData['file']);
        
            DB::commit();
            return response()->json(['message' => __('import').__('success')]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()],422);
        }
    }
}
