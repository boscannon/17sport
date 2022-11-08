@extends('backend.layouts.main')

@section('content')
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __('list') }}</h3>
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
        order: [[4, 'desc']],
        columns: [
            { data: 'null', title: '#', bSearchable: false, bSortable: false, render: function ( data, type, row , meta ) {
                return  meta.row + 1;
            }},
            { data: 'source', title: '{{ __("backend.$routeNameData.source") }}' },
            { data: 'no', title: '{{ __("backend.$routeNameData.no") }}' },   
            { data: 'barcode', title: '{{ __("backend.$routeNameData.barcode") }}' },   
            { data: 'name', title: '{{ __("backend.$routeNameData.name") }}' },   
            { data: 'type', title: '{{ __("backend.$routeNameData.type") }}' },   
            { data: 'size', title: '{{ __("backend.$routeNameData.size") }}' },   
            { data: 'amount', title: '{{ __("backend.$routeNameData.amount") }}' },   
            { data: 'stock', title: '{{ __("backend.$routeNameData.stock") }}' },   
            { data: 'created_at', title: '{{ __('created_at') }}' },
        ]
    });
});
</script>
@endpush
