@extends('backend.layouts.main')

@section('content')
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __('edit') }}</h3>
    </div>
    <div class="block-content block-content-full">
        <form id="form-edit" action="{{ route('backend.'.$routeNameData.'.update',[$routeIdData => $data->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#btabs-static-home">{{ __('basic_data') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-static-profile">{{ __('audit') }}</a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.no") }}<span class="text-danger">*</span></label>
                                <input type="text" required name="no" class="form-control" value="{{ $data->no }}" placeholder="{{ __("backend.$routeNameData.no") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.name") }}<span class="text-danger">*</span></label>
                                <input type="text" required name="name" class="form-control" value="{{ $data->name }}" placeholder="{{ __("backend.$routeNameData.name") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.uniform_numbers") }}</label>
                                <input type="text" name="uniform_numbers" class="form-control" value="{{ $data->uniform_numbers }}" placeholder="{{ __("backend.$routeNameData.uniform_numbers") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.principal") }}</label>
                                <input type="text" name="principal" class="form-control" value="{{ $data->principal }}" placeholder="{{ __("backend.$routeNameData.principal") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.address") }}</label>
                                <input type="text" name="address" class="form-control" value="{{ $data->address }}" placeholder="{{ __("backend.$routeNameData.address") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.contact_person") }}</label>
                                <input type="text" name="contact_person" class="form-control" value="{{ $data->contact_person }}" placeholder="{{ __("backend.$routeNameData.contact_person") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.telephone") }}</label>
                                <input type="text" name="telephone" class="form-control" value="{{ $data->telephone }}" placeholder="{{ __("backend.$routeNameData.telephone") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.email") }}</label>
                                <input type="email" name="email" class="form-control" value="{{ $data->email }}" placeholder="{{ __("backend.$routeNameData.email") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.business_items") }}</label>
                                <input type="text" name="business_items" class="form-control" value="{{ $data->business_items }}" placeholder="{{ __("backend.$routeNameData.business_items") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.tax") }}</label>
                                <input type="number" min="0" name="tax" class="form-control" value="{{ $data->tax }}" placeholder="{{ __("backend.$routeNameData.tax") }}" onkeyup="value=value.replace(/^[^\d]+/g,'')">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.billing_method_id") }}</label>
                                <select class="form-control" name="billing_method_id" data-placeholder="{{ __('please_choose') }}">
                                    <option value="">{{ __('please_choose') }}</option>
                                    @foreach($billingMethods as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->billing_method_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.tax_deduction_category_id") }}</label>
                                <select class="form-control" name="tax_deduction_category_id" data-placeholder="{{ __('please_choose') }}">
                                    <option value="">{{ __('please_choose') }}</option>
                                    @foreach($taxDeductionCategories as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->tax_deduction_category_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.invoice_address") }}</label>
                                <input type="text" name="invoice_address" class="form-control" value="{{ $data->invoice_address }}" placeholder="{{ __("backend.$routeNameData.invoice_address") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.invoice_issuing_company") }}</label>
                                <input type="text" name="invoice_issuing_company" class="form-control" value="{{ $data->invoice_issuing_company }}" placeholder="{{ __("backend.$routeNameData.invoice_issuing_company") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.bank_account") }}</label>
                                <input type="text" name="bank_account" class="form-control" value="{{ $data->bank_account }}" placeholder="{{ __("backend.$routeNameData.bank_account") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.payment_method_id") }}</label>
                                <select class="form-control" name="payment_method_id" data-placeholder="{{ __('please_choose') }}">
                                    <option value="">{{ __('please_choose') }}</option>
                                    @foreach($paymentMethods as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->payment_method_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.checkout_date") }}</label>
                                <input type="number" min="1" max="31" name="checkout_date" class="form-control" value="{{ $data->checkout_date }}" placeholder="{{ __("backend.$routeNameData.checkout_date") }}" onkeyup="value=value.replace(/^[^\d]+/g,'')">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.days") }}</label>
                                <input type="number" min="0" name="days" class="form-control" value="{{ $data->days }}" placeholder="{{ __("backend.$routeNameData.days") }}" onkeyup="value=value.replace(/^[^\d]+/g,'')">
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.other_instructions") }}</label>
                                <textarea name="other_instructions" class="form-control" placeholder="{{ __("backend.$routeNameData.other_instructions") }}">{{ $data->other_instructions }}</textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.remark") }}</label>
                                <textarea name="remark" class="form-control" placeholder="{{ __("backend.$routeNameData.remark") }}">{{ $data->remark }}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.status") }}<span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <label class="css-control css-control-primary css-switch">
                                        <input type="checkbox" class="css-control-input" {{ $data->status == 1 ? 'checked' : '' }}>
                                        <input type="hidden" required name="status" value="{{ $data->status }}">
                                        <span class="css-control-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="btabs-static-profile" role="tabpanel">
                        @include('backend.partials.audits', [ 'table' => $routeNameData, 'table_id' => $data->id ])
                    </div>
                </div>
            </div>
            <a href="{{ route('backend.'.$routeNameData.'.index') }}" class="btn btn-secondary">{{ __('back') }}</a>
            <button type="submit" class="btn btn-primary">{{ __('edit') }}</button>
        </form>
    </div>
</div>
@stop

@push('scripts')
<script>
$(function() {
    var path = '{{ route('backend.'.$routeNameData.'.index') }}';
    var formEdit = $('#form-edit');
    formEdit.ajaxForm({
        beforeSubmit: function(arr, $form, options) {    
            formEdit.find('button[type=submit]').attr('disabled',true);
        },
        success: function(data) {
            Swal.fire({ text: data.message, icon: 'success' }).then(function() {
                location.href = path;
            });
        },
        complete: function() {
            formEdit.find('button[type=submit]').attr('disabled',false);
        }
    });
});
</script>
@endpush
