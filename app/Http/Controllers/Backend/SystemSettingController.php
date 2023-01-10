<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\System_setting as crudModel;
use DataTables;
use Exception;

class SystemSettingController extends Controller
{
    public function __construct() {
        $this->name = 'system_settings';
        $this->view = 'backend.'.$this->name;
        $this->rules = [
            'key' => ['required', 'string', 'max:50', 'unique:App\Models\SystemS_setting'],
            'value' => ['required', 'string', 'max:255'],
        ];
        $this->messages = [];
        $this->attributes = __("backend.{$this->name}");
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
            $data = CrudModel::create($validatedData);
            return response()->json(['message' => __('create').__('success')]);
        } catch (Exception $e) {
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
        $this->rules['key'] = ['string', 'max:50', "unique:App\Models\System_setting,key,$id"];
        $validatedData = $request->validate($this->rules, $this->messages, $this->attributes);

        try{
            $data = CrudModel::findOrFail($id);
            $data->update($validatedData);
            return response()->json(['message' => __('edit').__('success')]);
        } catch (Exception $e) {
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
            $data = CrudModel::findOrFail($id);
            $data->delete();
            return response()->json(['message' => __('delete').__('success')]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()],422);
        }
    }
}
