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
                                <input type="text" required name="name" class="form-control" placeholder='{{ __("backend.$routeNameData.name") }}'>
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{ __("backend.$routeNameData.permissions") }}</label>
                                <div class="ml-2 form-group">                            
                                    @foreach(config('menu') as $key => $value)
                                        <div class="form-row">
                                            <label class="col-12">{{ __("backend.menu.{$value['title']}") }}</label>
                                        </div>
                                        @foreach($value['child'] as $sub_key => $sub_value)
                                            <div class="ml-3 form-row">
                                                <label class="col-2">{{ __("backend.menu.{$sub_value['title']}") }}</label>
                                                <div class="col-10">
                                                    @foreach($actions as $action)
                                                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                                                        <input 
                                                            class="custom-control-input" 
                                                            type="checkbox" name="permissions[]" 
                                                            id="permissions{{ $key.$sub_key.$action['permissions'] }}"
                                                            value="{{ $action['permissions'].' '.$sub_value['permissions'] }}"
                                                        >
                                                        <label class="custom-control-label" for="permissions{{ $key.$sub_key.$action['permissions'] }}">{{ $action["name"] }}</label>
                                                    </div>
                                                    @endforeach 
                                                </div>    
                                            </div>    
                                        @endforeach 
                                    @endforeach
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