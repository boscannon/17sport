<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role as crudModel;
use DataTables;
use Exception;
use DB;

class RoleController extends Controller
{
    public function __construct() {
        $this->name = 'roles';
        $this->view = 'backend.'.$this->name;
        $this->rules = [
            'name' => ['required', 'string', 'max:50', 'unique:App\Models\Role,name'],
            'permissions' => ['nullable', 'array'],
        ];
        $this->messages = [];
        $this->attributes = [
            'name' => __("backend.{$this->name}.name"),
            'permissions' => __("backend.{$this->name}.permissions"),
        ];
        $this->actions = [
            [ 'name' => __('read'), 'permissions' => 'read' ],
            [ 'name' => __('create'), 'permissions' => 'create' ],
            [ 'name' => __('edit'), 'permissions' => 'edit' ],
            [ 'name' => __('delete'), 'permissions' => 'delete' ],
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
        return view($this->view.'.create')->with('actions', $this->actions);
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

            $data = CrudModel::create(array_merge($validatedData, ['guard_name' => config('fortify.guard')]));
            $data->syncPermissions($validatedData['permissions'] ?? []);

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
        return view($this->view.'.edit',compact('data'))->with('actions', $this->actions);
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
        $this->rules['name'] = ['required', 'string', 'max:50', "unique:App\Models\Role,name,$id"];
        $validatedData = $request->validate($this->rules, $this->messages, $this->attributes);
        try{
            DB::beginTransaction();

            $data = CrudModel::findOrFail($id);
            $data->update($validatedData);
            $data->syncPermissions($validatedData['permissions'] ?? []);

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
            $data = CrudModel::findOrFail($id);
            $data->delete();
            return response()->json(['message' => __('delete').__('success')]);
        } catch (Exception $e) {
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
}
