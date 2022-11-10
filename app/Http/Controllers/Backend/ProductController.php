<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product as crudModel;
use DataTables;
use Exception;
use DB;

class ProductController extends Controller
{
    public function __construct() {
        $this->name = 'products';
        $this->view = 'backend.'.$this->name;
        $this->rules = [
            
            'yahoo_id' => ['nullable', 'string', 'max:150'],
            'momo_id' => ['nullable', 'string', 'max:150'],
            'momo_dt_code' => ['nullable', 'string', 'max:150'],
            'barcode' => ['required', 'string', 'max:150'],
            'name' => ['required', 'string', 'max:150'],
            'specification' => ['nullable', 'string', 'max:150'],
            'unit' => ['nullable', 'string', 'max:150'],
            'type' => ['nullable', 'string', 'max:150'],
            'size' => ['nullable', 'string', 'max:150'],
            'price' => ['nullable', 'numeric'],
            'stock' => ['nullable', 'numeric'],
            'attribute' => ['nullable', 'string', 'max:255'],
            'remark' => ['nullable', 'string'],            
        ];
        $this->messages = [];
        $this->attributes = [            
            'yahoo_id' => __("backend.{$this->name}.yahoo_id"),
            'momo_id' => __("backend.{$this->name}.momo_id"),
            'momo_dt_code' => __("backend.{$this->name}.momo_dt_code"),
            'barcode' => __("backend.{$this->name}.barcode"),
            'name' => __("backend.{$this->name}.name"),
            'specification' => __("backend.{$this->name}.specification"),
            'unit' => __("backend.{$this->name}.unit"),
            'type' => __("backend.{$this->name}.type"),
            'size' => __("backend.{$this->name}.size"),
            'price' => __("backend.{$this->name}.price"),
            'stock' => __("backend.{$this->name}.stock"),
            'attribute' => __("backend.{$this->name}.attribute"),
            'remark' => __("backend.{$this->name}.remark"),
        ];
    }

    public function index(Request $request)
    {
        $this->authorize('read '.$this->name);
        if ($request->ajax()) {
            $data = CrudModel::query();
            return Datatables::eloquent($data)
                ->make(true);
        }
        return view($this->view.'.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create '.$this->name);
        return view($this->view.'.create');
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

            $data = CrudModel::create($validatedData);

            DB::commit();
            return response()->json(['message' => __('create').__('success')]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('read '.$this->name);
        return CrudModel::findOrFail($id); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $this->authorize('edit '.$this->name);
        $data = CrudModel::findOrFail($id);
        return view($this->view.'.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit '.$this->name);
        $validatedData = $request->validate($this->rules, $this->messages, $this->attributes);

        try{DB::beginTransaction();

            $data = CrudModel::findOrFail($id);
            $data->update($validatedData);

            DB::commit();
            return response()->json(['message' => __('edit').__('success')]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete '.$this->name);
        try{
            DB::beginTransaction();

            $data = CrudModel::findOrFail($id);
            $data->delete();

            DB::commit();
            return response()->json(['message' => __('delete').__('success')]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()],422);
        }
    }

    /**
     * status  the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id)
    {
        $this->authorize('edit '.$this->name);
        $validatedData = $request->validate(['status' => ['required', 'boolean']], [], ['status' => __('status'),]);

        try{
            $data = CrudModel::findOrFail($id);
            $data->update($validatedData);
            return response()->json(['message' => __('edit').__('success')]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()],422);
        }
    }

    public function select(Request $request)
    {
        $this->authorize('read '.$this->name);
        if ($request->ajax()) {
            $data = CrudModel::where('name', 'like', "%{$request->search}%")
                ->where('barcode', 'like', "%{$request->search}%")
                ->select(['id', 'name', 'barcode'])
                ->limit(200)
                ->get();
            return $data;
        }
    }

}
