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
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.name") }}<span class="text-danger">*</span></label>
                                <input type="text" required name="name" class="form-control" value="{{ $data->name }}" placeholder="{{ __("backend.$routeNameData.name") }}">
                            </div>                        
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.email") }}<span class="text-danger">*</span></label>
                                <input type="email" required name="email" class="form-control"  value="{{ $data->email }}" placeholder="{{ __("backend.$routeNameData.email") }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.staff_id") }}<span class="text-danger">*</span></label>
                                <select class="js-select2 form-control" required name="staff_id" data-placeholder="{{ __("backend.$routeNameData.staff_id") }}">                                    
                                    @foreach($staff as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->staff_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>                            
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.password") }}</label>
                                <input type="password" name="password" class="form-control"  value="" placeholder="{{ __("backend.$routeNameData.password") }}">
                            </div>   
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.password_confirmation") }}</label>
                                <input type="password" name="password_confirmation" class="form-control" value="" placeholder="{{ __("backend.$routeNameData.password_confirmation") }}">
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
