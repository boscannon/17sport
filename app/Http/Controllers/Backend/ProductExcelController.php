<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product as crudModel;
use DataTables;
use Exception;

use App\Imports\ProductExcelImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductExcelController extends Controller
{
    public function __construct() {
        $this->name = 'products';
        $this->view = 'backend.'.$this->name;
        $this->rules = [
            'file' => ['required', 'file'],         
        ];
        $this->messages = [];
        $this->attributes = __("backend.{$this->name}");
    }

    public function index(Request $request)
    {
        $this->authorize('read '.$this->name);
        return response()->download(public_path('product.xlsx'));
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
            $import = new ProductExcelImport;
            $error = Excel::import($import, $validatedData['file']);
        
            return response()->json(['message' => __('import').__('success')]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()],422);
        }
    }
}
