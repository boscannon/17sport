<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department as crudModel;
use DataTables;
use Exception;

class DepartmentController extends Controller
{
    public function __construct() {
        $this->name = 'departments';
        $this->view = 'backend.'.$this->name;
        $this->rules = [
            'no' => ['required', 'string', 'max:50', 'unique:App\Models\Department'],
            'name' => ['required', 'string', 'max:50'],
            'parent_id' => ['nullable', 'numeric', 'exists:App\Models\Department,id'],
            'level' => ['numeric'],
            'remark' => ['nullable', 'string'],
        ];
        $this->messages = [];
        $this->attributes = [
            'no' => __("backend.{$this->name}.no"),
            'name' => __("backend.{$this->name}.name"),
            'parent_id' => __("backend.{$this->name}.parent_id"),
            'level' => __("backend.{$this->name}.level"),
            'remark' => __("backend.{$this->name}.remark"),
        ];
    }

    public function index(Request $request)
    {
        $this->authorize('read '.$this->name);
        if ($request->ajax()) {
            $data = CrudModel::with('parent');
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
        $departments = CrudModel::all();
        return view($this->view.'.create', compact('departments'));
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
        $departments = CrudModel::where('id', '!=', $id)->get();
        return view($this->view.'.edit',compact('data', 'departments'));
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
        $this->rules['no'] = ['required', 'string', 'max:50', "unique:App\Models\Department,no,$id"];
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
