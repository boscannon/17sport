<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff as crudModel;
use App\Models\Department;
use DataTables;
use Exception;

class StaffController extends Controller
{
    public function __construct() {
        $this->name = 'staff';
        $this->view = 'backend.'.$this->name;
        $this->rules = [
            'no' => ['required', 'string', 'max:50', "unique:App\Models\Staff"],
            'name' => ['required', 'string', 'max:50'],
            'english_name' => ['nullable', 'string', 'max:50'],
            'identification' => ['required', 'string', 'max:10'],
            'department_id' => ['required', 'exists:App\Models\Department,id'],
            'appointment_date' => ['nullable', 'date'],
            'resignation_date' => ['nullable', 'date'],
            'telephone' => ['nullable', 'string', 'max:10'],
            'cellphone' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string', 'max:200'],
            'email' => ['nullable', 'string', 'max:150'],
            'line' => ['nullable', 'string', 'max:50'],
            'emergency_contact' => ['nullable', 'string', 'max:50'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:10'],
            'remark' => ['nullable', 'string', 'max:200'],
        ];
        $this->messages = [];
        $this->attributes = [
            'no' => __("backend.{$this->name}.no"),
            'name' => __("backend.{$this->name}.name"),
            'english_name' => __("backend.{$this->name}.english_name"),
            'identification' => __("backend.{$this->name}.identification"),
            'department_id' => __("backend.{$this->name}.department_id"),
            'appointment_date' => __("backend.{$this->name}.appointment_date"),
            'resignation_date' => __("backend.{$this->name}.resignation_date"),
            'telephone' => __("backend.{$this->name}.telephone"),
            'cellphone' => __("backend.{$this->name}.cellphone"),
            'address' => __("backend.{$this->name}.address"),
            'email' => __("backend.{$this->name}.email"),
            'line' => __("backend.{$this->name}.line"),
            'emergency_contact' => __("backend.{$this->name}.emergency_contact"),
            'emergency_contact_phone' => __("backend.{$this->name}.emergency_contact_phone"),
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
        $departments = Department::all();
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
        $departments = Department::all();
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
        $this->rules['no'] = ['required', 'string', 'max:50', "unique:App\Models\Staff,no,$id"];
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
