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
                                <label>{{ __("backend.$routeNameData.yahoo_id") }}<span class="text-danger">*</span></label>
                                <input type="text" required name="yahoo_id" class="form-control" value="{{ $data->yahoo_id }}" placeholder="{{ __("backend.$routeNameData.yahoo_id") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.momo_id") }}<span class="text-danger">*</span></label>
                                <input type="text" required name="momo_id" class="form-control" value="{{ $data->momo_id }}" placeholder="{{ __("backend.$routeNameData.momo_id") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.barcode") }}<span class="text-danger">*</span></label>
                                <input type="text" required name="barcode" class="form-control" value="{{ $data->barcode }}" placeholder="{{ __("backend.$routeNameData.barcode") }}">
                            </div>                            
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.name") }}<span class="text-danger">*</span></label>
                                <input type="text" required name="name" class="form-control" value="{{ $data->name }}" placeholder="{{ __("backend.$routeNameData.name") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.specification") }}</label>
                                <input type="text" name="specification" class="form-control" value="{{ $data->specification }}" placeholder="{{ __("backend.$routeNameData.specification") }}">
                            </div>                                                        
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.unit") }}</label>
                                <input type="text" name="unit" class="form-control" value="{{ $data->unit }}" placeholder="{{ __("backend.$routeNameData.unit") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.type") }}</label>
                                <input type="text" name="type" class="form-control" value="{{ $data->type }}" placeholder="{{ __("backend.$routeNameData.type") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.size") }}</label>
                                <input type="text" name="size" class="form-control" value="{{ $data->size }}" placeholder="{{ __("backend.$routeNameData.size") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.price") }}</label>
                                <input type="text" name="price" class="form-control" value="{{ $data->price }}" placeholder="{{ __("backend.$routeNameData.price") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.stock") }}</label>
                                <input type="text" name="stock" class="form-control" value="{{ $data->stock }}" placeholder="{{ __("backend.$routeNameData.stock") }}">
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
