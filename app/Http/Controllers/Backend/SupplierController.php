<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier as crudModel;
use App\Models\BillingMethod;
use App\Models\TaxDeductionCategory;
use App\Models\PaymentMethod;
use DataTables;
use Exception;

class SupplierController extends Controller
{
    public function __construct() {
        $this->name = 'suppliers';
        $this->view = 'backend.'.$this->name;
        $this->rules = [
            'no' => ['required', 'string', 'max:50', 'unique:App\Models\Supplier'],
            'name' => ['required', 'string', 'max:50'],
            'uniform_numbers' => ['nullable', 'string', 'max:50'],
            'principal' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:100'],
            'contact_person' => ['nullable', 'string', 'max:50'],
            'telephone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'business_items' => ['nullable', 'string', 'max:50'],
            'tax' => ['nullable', 'numeric'],
            'billing_method_id' => ['nullable', 'string', 'exists:App\Models\BillingMethod,id'],
            'tax_deduction_category_id' => ['nullable', 'string', 'exists:App\Models\TaxDeductionCategory,id'],
            'invoice_address' => ['nullable', 'string', 'max:50'],
            'invoice_issuing_company' => ['nullable', 'string', 'max:50'],
            'checkout_date' => ['nullable', 'numeric'],
            'remark' => ['nullable', 'string'],
            'payment_method_id' => ['nullable', 'string', 'exists:App\Models\PaymentMethod,id'],
            'days' => ['nullable', 'numeric'],
            'other_instructions' => ['nullable', 'string'],
            'bank_account' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'boolean'],
            'retirement_date' => ['nullable', 'date'],
        ];
        $this->messages = [];
        $this->attributes = [
            'no' => __("backend.{$this->name}.no"),
            'name' => __("backend.{$this->name}.name"),
            'uniform_numbers' => __("backend.{$this->name}.uniform_numbers"),
            'principal' => __("backend.{$this->name}.principal"),
            'address' => __("backend.{$this->name}.address"),
            'contact_person' => __("backend.{$this->name}.contact_person"),
            'telephone' => __("backend.{$this->name}.telephone"),
            'email' => __("backend.{$this->name}.email"),
            'business_items' => __("backend.{$this->name}.business_items"),
            'tax' => __("backend.{$this->name}.tax"),
            'billing_method_id' => __("backend.{$this->name}.billing_method_id"),
            'tax_deduction_category_id' => __("backend.{$this->name}.tax_deduction_category_id"),
            'invoice_address' => __("backend.{$this->name}.invoice_address"),
            'invoice_issuing_company' => __("backend.{$this->name}.invoice_issuing_company"),
            'checkout_date' => __("backend.{$this->name}.checkout_date"),
            'remark' => __("backend.{$this->name}.remark"),
            'payment_method_id' => __("backend.{$this->name}.payment_method_id"),
            'days' => __("backend.{$this->name}.days"),
            'other_instructions' => __("backend.{$this->name}.other_instructions"),
            'bank_account' => __("backend.{$this->name}.bank_account"),
            'status' => __("backend.{$this->name}.status"),
            'retirement_date' => __("backend.{$this->name}.retirement_date"),
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
        $billingMethods = BillingMethod::all();
        $taxDeductionCategories = TaxDeductionCategory::all();
        $paymentMethods = PaymentMethod::all();
        return view($this->view.'.create', compact('billingMethods', 'taxDeductionCategories', 'paymentMethods'));
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
        $billingMethods = BillingMethod::all();
        $taxDeductionCategories = TaxDeductionCategory::all();
        $paymentMethods = PaymentMethod::all();
        return view($this->view.'.edit',compact('data', 'billingMethods', 'taxDeductionCategories', 'paymentMethods'));
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
        $this->rules['no'] = ['required', 'string', 'max:50', "unique:App\Models\Supplier,no,$id"];
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
