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
                                <label>{{ __("backend.$routeNameData.name") }}<span class="text-danger">*</span></label>
                                <input type="text" required name="name" class="form-control" placeholder="{{ __("backend.$routeNameData.name") }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.email") }}<span class="text-danger">*</span></label>
                                <input type="email" required name="email" class="form-control" placeholder="{{ __("backend.$routeNameData.email") }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.password") }}<span class="text-danger">*</span></label>
                                <input type="password" required name="password" class="form-control"  value="" placeholder="{{ __("backend.$routeNameData.password") }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.password_confirmation") }}<span class="text-danger">*</span></label>
                                <input type="password" required name="password_confirmation" class="form-control" value="" placeholder="{{ __("backend.$routeNameData.password_confirmation") }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __("backend.$routeNameData.status") }}<span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <label class="css-control css-control-primary css-switch">
                                        <input type="checkbox" class="css-control-input" checked>
                                        <input type="hidden" required name="status" value="1">
                                        <span class="css-control-indicator"></span>
                                    </label>
                                </div>
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