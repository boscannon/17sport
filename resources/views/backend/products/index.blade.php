@extends('backend.layouts.main')

@section('content')
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __("backend.$routeNameData.bulk_add") }} <span class="text-danger">({{ __("backend.$routeNameData.bulk_add_info") }})</span></h3>
    </div>
    <div class="block-content block-content-full">
        <form id="form-create" action="{{ route('backend.products_excel.store') }}" method="post">
            <div class="form-row mr-5">
                <div class="form-group col-md-4">
                    <div class="custom-file">
                        <input type="file" required class="custom-file-input" id="example-file-input-custom" name="file" data-toggle="custom-file-input" accept=".xlsx, .xls, .csv">
                        <label class="custom-file-label" for="example-file-input-custom">{{ __('Choose file') }}</label>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-upload mr-5"></i>{{ __('upload') }}</button>
                    <a href="{{ route('backend.products_excel.index') }}" target="_blank" class="btn btn-info"><i class="fa fa-download mr-5"></i>{{ __("backend.$routeNameData.ecxel_download") }}</a>                
                </div>
            </div>
            <div class="spinner-border text-primary upload-loading" role="status">
                <span class="sr-only">Loading...</span>
            </div>             
        </form>               
    </div>
</div>
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __('list') }}</h3>
        <a href="{{ route('backend.'.$routeNameData.'.create') }}" class="btn btn-primary mr-2">{{ __('create') }}</a>
    </div>
    <div class="block-content block-content-full">
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full nowrap" id="data-table" style="width:100%">
            <thead>
            </thead>
        </table>
    </div>
</div>  
@stop

@push('scripts')
<script>
$(function() {
    var path = '{{ route('backend.'.$routeNameData.'.index') }}';
    var tableList = $('#data-table');
    var formCreate = $('#form-create');
    var table = tableList.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        ajax: path,
        order: [[5, 'desc']],
        columns: [
            { data: 'null', title: '#', bSearchable: false, bSortable: false, render: function ( data, type, row , meta ) {
                return  meta.row + 1;
            }},
            { data: 'barcode', title: '{{ __("backend.$routeNameData.barcode") }}' },
            { data: 'name', title: '{{ __("backend.$routeNameData.name") }}' },   
            { data: 'stock', title: '{{ __("backend.$routeNameData.stock") }}' },   
            { data: 'created_at', title: '{{ __('created_at') }}' },
            { data: 'updated_at', title: '{{ __('updated_at') }}' },
            { data: 'id', title: '{{ __('option') }}', bSortable: false, render:function(data,type,row) {
                return `<a class="edit" href="${ path }/${ data }/edit">{{ __('edit') }}</a> |
                    <a data-id="${ data }" class="delete" href="javascript:;">{{ __('delete') }}</a>`;
            }},
        ]
    });

    var formCreate = $('#form-create');    
    formCreate.find('.spinner-border').hide();
    formCreate.ajaxForm({
        beforeSubmit: function(arr, $form, options) {                        
            formCreate.find('button[type=submit]').attr('disabled',true);
            formCreate.find('.spinner-border').show();
        },   
        success: function(data) {
            Swal.fire({ text: data.message, icon: 'success' }).then(function() {
                table.ajax.reload(null, false);
            });
        },
        complete: function() {
            formCreate.find('button[type=submit]').attr('disabled',false);
            formCreate.find('.spinner-border').hide();
        }
    }); 

    tableList.on('click','.css-switch input[type="checkbox"]',function(){
        var id = $(this).data('id');
        $.get(`${ path }/${ id }`, function(row) {
            row.status = row.status ? 0 : 1;
            $.ajax({
                url: `${ path }/status/${ id }`,
                type: 'PUT',
                dataType: 'json',
                data: row,
                success: function(data) {
                    Swal.fire({ text: data.message, icon: 'success' }).then(function() {
                        table.ajax.reload(null, false);
                    }); 
                },
            }); 
        })       
    })

    tableList.on('click','.delete',function(){
        var id = $(this).data('id');
        Swal.fire({ 
            text: '{{ __('confirm_delete') }}',
            icon: 'warning',
            showCancelButton: true, 
            confirmButtonText: '{{ __('sure') }}',
            cancelButtonText: '{{ __('cancel') }}'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${ path }/${ id }`,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(data) {
                        Swal.fire({ text: data.message, icon: 'success' }).then(function() {
                            table.ajax.reload(null, false);
                        }); 
                    },
                });
            }
        });
    })
});
</script>
@endpush
