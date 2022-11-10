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
            { className: 'dt-control', bSearchable: false, orderable: false, data: null, defaultContent: '' },
            { data: 'null', title: '#', bSearchable: false, bSortable: false, render: function ( data, type, row , meta ) {
                return  meta.row + 1;
            }},
            
            { data: 'no', title: '{{ __("backend.$routeNameData.no") }}' },   
            { data: 'source', title: '{{ __("backend.$routeNameData.source") }}' },
            { data: 'date', title: '{{ __("backend.$routeNameData.date") }}' },   
            { data: 'recipient_name', title: '{{ __("backend.$routeNameData.recipient_name") }}' },   
            { data: 'recipient_phone', title: '{{ __("backend.$routeNameData.recipient_phone") }}' },   
            { data: 'recipient_cellphone', title: '{{ __("backend.$routeNameData.recipient_cellphone") }}' },   
            { data: 'purchaser_name', title: '{{ __("backend.$routeNameData.purchaser_name") }}' },   
            { data: 'purchaser_cellphone', title: '{{ __("backend.$routeNameData.purchaser_cellphone") }}' }, 
            { data: 'due_date', title: '{{ __("backend.$routeNameData.due_date") }}' }, 
            { data: 'remark', title: '{{ __("backend.$routeNameData.remark") }}' }, 

            { data: 'created_at', title: '{{ __('created_at') }}' },
        ]
    });

    tableList.on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
 
        if (row.child.isShown()) {            
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    function format(d) {        
        return (
            `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; width: 100%">
                <tr>
                    <th>{{ __("backend.$routeNameData.barcode") }}</th>
                    <th>{{ __("backend.$routeNameData.name") }}</th>
                    <th>{{ __("backend.$routeNameData.amount") }}</th>                
                </tr>
                ${
                    d.stock_detail && d.stock_detail.map(item => `
                        <tr>
                            <td>${ _.get(item, 'product.barcode', '') }</td>
                            <td>${ _.get(item, 'name', '') }</td>
                            <td>${ _.get(item, 'amount', '') }</td>
                        </tr>
                    `).join("\n") || '<tr></tr>'
                }
            </table>`
        );         
    }
});
</script>
@endpush
