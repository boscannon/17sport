@extends('backend.layouts.main')

@section('content')
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __('create') }}</h3>
    </div>
    <div class="block-content block-content-full">
        <form id="form-create" action="{{ route('backend.'.$routeNameData.'.store') }}" method="post">
            @csrf
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#btabs-static-home">{{ __('basic_data') }}</a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <div class="tab-pane active" id="btabs-static-home" role="tabpanel">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.yahoo_id") }}</label>
                                <input type="text" name="yahoo_id" class="form-control" placeholder="{{ __("backend.$routeNameData.yahoo_id") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.momo_id") }}</label>
                                <input type="text" name="momo_id" class="form-control" placeholder="{{ __("backend.$routeNameData.momo_id") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.momo_dt_code") }}</label>
                                <input type="text" name="momo_dt_code" class="form-control" placeholder="{{ __("backend.$routeNameData.momo_dt_code") }}">
                            </div>                            
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.barcode") }}<span class="text-danger">*</span></label>
                                <input type="text" required name="barcode" class="form-control" placeholder="{{ __("backend.$routeNameData.barcode") }}">
                            </div>                            
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.name") }}<span class="text-danger">*</span></label>
                                <input type="text" required name="name" class="form-control" placeholder="{{ __("backend.$routeNameData.name") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.specification") }}</label>
                                <input type="text" name="specification" class="form-control" placeholder="{{ __("backend.$routeNameData.specification") }}">
                            </div>                                                        
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.unit") }}</label>
                                <input type="text" name="unit" class="form-control" placeholder="{{ __("backend.$routeNameData.unit") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.type") }}</label>
                                <input type="text" name="type" class="form-control" placeholder="{{ __("backend.$routeNameData.type") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.size") }}</label>
                                <input type="text" name="size" class="form-control" placeholder="{{ __("backend.$routeNameData.size") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.price") }}</label>
                                <input type="text" name="price" class="form-control" placeholder="{{ __("backend.$routeNameData.price") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.stock") }}</label>
                                <input type="text" name="stock" class="form-control" placeholder="{{ __("backend.$routeNameData.stock") }}">
                            </div>                            
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.attribute") }}</label>
                                <textarea name="attribute" class="form-control" placeholder="{{ __("backend.$routeNameData.attribute") }}"></textarea>
                            </div>                        
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.remark") }}</label>
                                <textarea name="remark" class="form-control" placeholder="{{ __("backend.$routeNameData.remark") }}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('backend.'.$routeNameData.'.index') }}" class="btn btn-secondary">{{ __('back') }}</a>
            <button type="submit" class="btn btn-primary">{{ __('create') }}</button>
        </form>
    </div>
</div>
@stop

@push('scripts')
<script>
$(function() {
    var path = '{{ route('backend.'.$routeNameData.'.index') }}';
    var formCreate = $('#form-create');
    formCreate.ajaxForm({
        beforeSubmit: function(arr, $form, options) {
            formCreate.find('button[type=submit]').attr('disabled',true);
        },
        success: function(data) {
            Swal.fire({ text: data.message, icon: 'success' }).then(function() {
                location.href = path;
            });
        },
        complete: function() {
            formCreate.find('button[type=submit]').attr('disabled',false);
        }
    });
});
</script>
@endpush