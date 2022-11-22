@extends('backend.layouts.main')

@section('content')
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __("search") }}</h3>
    </div>
    <div class="block-content block-content-full">
        <form id="form-search" onsubmit="return false">
            <div class="form-row mr-5">
                <div class="form-group col-md-4">
                    <label for="example-flatpickr-range">{{ __("date_range") }}</label>
                    <input type="text" name="dateRange" class="js-flatpickr form-control bg-white" id="example-flatpickr-range" name="example-flatpickr-range" placeholder="Select Date Range" data-mode="range">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">{{ __('search') }}</button>
        </form>
    </div>
</div>
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
        ajax: {
            url: path,
            data: function ( d ) {
                d.dateRange = $("#form-search input[name=dateRange]").val();
            }
        },
        order: [[4, 'asc'],[5, 'asc']],
        columns: [
            { className: 'dt-control', bSearchable: false, orderable: false, data: null, defaultContent: '' },
            { data: 'null', title: '#', bSearchable: false, bSortable: false, render: function ( data, type, row , meta ) {
                return  meta.row + 1;
            }},
            { data: 'no', title: '{{ __("backend.$routeNameData.no") }}' },   
            { data: 'source', title: '{{ __("backend.$routeNameData.source") }}' },
            { data: 'stock_detail_count', title: '{{ __("backend.$routeNameData.stock_detail_count") }}', bSearchable: false, render: function ( data, type, row , meta ) {
                return  `${ data == 0 ? '<span class="badge badge-danger">{{ __("backend.$routeNameData.not_match") }}</span>' : 
                '<span class="badge badge-success">{{ __("backend.$routeNameData.match") }}' }</span>`;
            }},
            { data: 'date', title: '{{ __("backend.$routeNameData.date") }}' },
            { data: 'stock_detail', title: '{{ __("backend.$routeNameData.name") }}', defaultContent: '', render: function ( data, type, row , meta ) {
                return `<pre style="margin: 0">${ data.map((item) => item.product.name).join("\n") }</pre>`;
            } },
            { data: 'stock_detail', title: '{{ __("backend.$routeNameData.size") }}', defaultContent: '', render: function ( data, type, row , meta ) {
                return `<pre style="margin: 0">${ data.map((item) => item.product.size).join("\n") }</pre>`;
            } },
            { data: 'date', title: '{{ __("backend.$routeNameData.date") }}' },
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

    $('#form-search').submit(function(){
        table.draw();
    })

    function format(d) {
        return (
            `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; width: 100%">
                <tr>
                    <th style="width: 10%;">{{ __("backend.$routeNameData.barcode") }}</th>
                    <th style="width: 5%;">{{ __("backend.$routeNameData.amount") }}</th>
                    <th>{{ __("backend.$routeNameData.name") }}</th>
                </tr>
                ${
                    d.stock_detail && d.stock_detail.map(item => `
                        <tr>
                            <td>${ _.get(item, 'product.barcode', '') }</td>
                            <td>${ _.get(item, 'amount', '') }</td>
                            <td>${ _.get(item, 'name', '') }</td>
                        </tr>
                    `).join("\n") || '<tr><td>{{ __("not_data") }}</td></tr>'
                }
            </table>`
        );
    }
});
</script>
@endpush
