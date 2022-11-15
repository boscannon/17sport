<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product as crudModel;
use DataTables;
use Exception;

use App\Imports\StockShoplineImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Service\UpdateOrdersStock;

class StockShoplineController extends Controller
{
    public function __construct(UpdateOrdersStock $UpdateOrdersStock) {
        $this->name = 'stock_details';
        $this->view = 'backend.'.$this->name;
        $this->rules = [
            'file' => ['required', 'file', 'mimes:xls,xlsx,csv'],
        ];
        $this->messages = [];
        $this->attributes = __("backend.{$this->name}");

        $this->UpdateOrdersStock = $UpdateOrdersStock;
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
            //更新商品 跟 新增庫存明細
            Excel::import(new StockShoplineImport, $validatedData['file']);
            //更新平台庫存
            $this->UpdateOrdersStock->updateStock();

            return response()->json(['message' => __('import').__('success'), 'ignore' => $ignore]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()],422);
        }
    }
}
