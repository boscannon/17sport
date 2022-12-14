@extends('backend.layouts.main')

@section('content')
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __('edit') }}</h3>
    </div>
    <div class="block-content block-content-full">
        <form id="form-edit" action="{{ route('backend.'.$routeNameData.'.update',[$routeIdData => $data->id]) }}" method="post">
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
                                <label>{{ __("backend.$routeNameData.identification") }}<span class="text-danger">*</span></label>
                                <input type="text" required name="identification" class="form-control" value="{{ $data->identification }}" placeholder="{{ __("backend.$routeNameData.identification") }}">
                            </div>                                                        
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.department_id") }}<span class="text-danger">*</span></label>
                                <select class="js-select2 form-control" name="department_id" data-placeholder="{{ __("backend.$routeNameData.department_id") }}">
                                    <option></option>
                                    @foreach($departments as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->department_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>   
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.appointment_date") }}</label>
                                <input type="date" name="appointment_date" class="form-control" value="{{ $data->appointment_date }}" placeholder="{{ __("backend.$routeNameData.appointment_date") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.resignation_date") }}</label>
                                <input type="date" name="resignation_date" class="form-control" value="{{ $data->resignation_date }}" placeholder="{{ __("backend.$routeNameData.resignation_date") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.telephone") }}</label>
                                <input type="text" name="telephone" class="form-control" value="{{ $data->telephone }}" placeholder="{{ __("backend.$routeNameData.telephone") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.cellphone") }}</label>
                                <input type="text" name="cellphone" class="form-control" value="{{ $data->cellphone }}" placeholder="{{ __("backend.$routeNameData.cellphone") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.address") }}</label>
                                <input type="text" name="address" class="form-control" value="{{ $data->address }}" placeholder="{{ __("backend.$routeNameData.address") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.email") }}</label>
                                <input type="email" name="email" class="form-control" value="{{ $data->email }}" placeholder="{{ __("backend.$routeNameData.email") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.emergency_contact") }}</label>
                                <input type="text" name="emergency_contact" class="form-control" value="{{ $data->emergency_contact }}" placeholder="{{ __("backend.$routeNameData.emergency_contact") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.emergency_contact_phone") }}</label>
                                <input type="text" name="emergency_contact_phone" class="form-control" value="{{ $data->emergency_contact_phone }}" placeholder="{{ __("backend.$routeNameData.emergency_contact_phone") }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.remark") }}</label>
                                <textarea name="remark" class="form-control" placeholder="{{ __("backend.$routeNameData.remark") }}">{{ $data->remark }}</textarea>
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
