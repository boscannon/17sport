<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product as crudModel;
use DataTables;
use Exception;
use DB;

use App\Imports\ProductShoplineImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductExcelController extends Controller
{
    public function __construct() {
        $this->name = 'products';
        $this->view = 'backend.'.$this->name;
        $this->rules = [
            'file' => ['required', 'string', 'max:150'],         
        ];
        $this->messages = [];
        $this->attributes = [
            'file' => __("backend.{$this->name}.file"),
        ];
    }

    public function index(Request $request)
    {
        $this->authorize('read '.$this->name);
        return response()->download(public_path('favicon.ico'));
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

            Excel::import(new ProductShoplineImport, $validatedData['file']);
        
            DB::commit();
            return response()->json(['message' => __('import').__('success')]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()],422);
        }
    }
}
