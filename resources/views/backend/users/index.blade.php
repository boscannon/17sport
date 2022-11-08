@extends('backend.layouts.main')

@section('content')
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __('list') }}</h3>
        <a href="{{ route('backend.'.$routeNameData.'.create') }}" class="btn btn-primary">{{ __('create') }}</a>
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
        order: [[6, 'desc']],
        columns: [
            { data: 'null', title: '#', bSearchable: false, bSortable: false, render: function ( data, type, row , meta ) {
                return  meta.row + 1;
            }},
            { data: 'name', title: '{{ __("backend.$routeNameData.name") }}' },
            { data: 'email', title: '{{ __("backend.$routeNameData.email") }}' },
            { data: 'staff.name', title: '{{ __("backend.$routeNameData.staff_id") }}' },
            {
                data: "status", title: '{{ __('status') }}',
                render: function ( data, type, row ) {   
                    return`
                        <label class="css-control css-control-sm css-control-primary css-switch">
                            <input type="checkbox" data-id="${ row.id }" class="status css-control-input" ${ data == 1 ? 'checked' : '' }>
                            <span class="css-control-indicator"></span>
                        </label>`;            
                },
                className: "dt-body-center"
            },            
            { data: 'created_at', title: '{{ __('created_at') }}' },
            { data: 'updated_at', title: '{{ __('updated_at') }}' },
            { data: 'id', title: '{{ __('option') }}', bSortable: false, render:function(data,type,row) {
                return `<a class="edit" href="${ path }/${ data }/edit">{{ __('edit') }}</a> |
                    <a data-id="${ data }" class="delete" href="javascript:;">{{ __('delete') }}</a>`;
            }},
        ]
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
                        if(id == {{ Auth::user()->id }}){
                            location.reload();
                            return;
                        }
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
