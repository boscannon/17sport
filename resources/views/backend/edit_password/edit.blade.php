@extends('backend.layouts.main')

@section('content')
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __('edit') }}</h3>
    </div>
    <div class="block-content block-content-full">            
        <form id="form-edit" action="{{ route('backend.edit_password.store') }}" method="post">
            @csrf
            <div class="form-row">                 
                <div class="form-group col-md-12">
                    <label>{{ __('password') }}</label>
                    <input type="password" name="old_password" class="form-control" required placeholder="{{ __('password') }}">
                </div>   
                <div class="form-group col-md-12">
                    <label>{{ __('newly').__('password') }}</label>
                    <input type="password" name="newly_password" class="form-control" required placeholder="{{ __('newly').__('password') }}">
                </div>   
                <div class="form-group col-md-12">
                    <label>{{ __('newly').__('password_confirmation') }}</label>
                    <input type="password" name="newly_password_confirmation" class="form-control" required placeholder="{{ __('newly').__('password_confirmation') }}">
                </div>   
            </div>
            <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
        </form>
    </div>
</div>
@stop

@push('scripts')
<script>
$(function() {
    var formCreate = $('#form-edit');
    formCreate.ajaxForm({
        beforeSubmit: function(arr, $form, options) {    
            formCreate.find('button[type=submit]').attr('disabled',true);
        },
        success: function(data) {
            Swal.fire({ text: data.message, icon: 'success' }).then(function() {
                location.href = '/backend/home';
            });            
        },
        complete: function() {
            formCreate.find('button[type=submit]').attr('disabled',false);
        }
    });
});
</script>    
@endpush