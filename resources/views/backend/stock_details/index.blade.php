@extends('backend.layouts.main')

@section('content')
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __("backend.$routeNameData.shopline_update_stock") }}</h3>
    </div>
    <div class="block-content block-content-full">
        <form id="form-create" action="{{ route('backend.stock_shopline.store') }}" method="post">
            <div class="form-row mr-5">
                <div class="form-group col-md-4">
                    <div class="custom-file">
                        <input type="file" required class="custom-file-input" id="example-file-input-custom" name="file" data-toggle="custom-file-input">
                        <label class="custom-file-label" for="example-file-input-custom">{{ __('Choose file') }}</label>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-upload mr-5"></i>{{ __('upload') }}</button>
                </div>
            </div>
        </form>        
    </div>
</div>
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __("search") }}</h3>
    </div>
    <div class="block-content block-content-full">
        <form id="form-search" action="{{ route('backend.stock_shopline.store') }}" method="post" onsubmit="return false">
            <div class="form-row mr-5">
                <div class="form-group col-md-4">
                    <label for="example-flatpickr-range">{{ __("date_range") }}</label>
                    <input type="text" name="dateRange" class="js-flatpickr form-control bg-white" id="example-flatpickr-range" name="example-flatpickr-range" placeholder="Select Date Range" data-mode="range">
                </div> 
                <div class="form-group col-md-4">
                    <label>{{ __("backend.$routeNameData.product_id") }}</label>
                    <select class="js-select2 form-control" multiple name="product_id[]" data-placeholder="{{ __("backend.$routeNameData.product_id") }}">                        
                    </select>
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
                d['product_id[]'] = $("#form-search select[name='product_id[]']").val();
            }
        },
        order: [[9, 'desc']],
        columns: [
            { data: 'null', title: '#', bSearchable: false, bSortable: false, render: function ( data, type, row , meta ) {
                return  meta.row + 1;
            }},
            { data: 'source', title: '{{ __("backend.$routeNameData.source") }}' },
            { data: 'order.no', title: '{{ __("backend.$routeNameData.no") }}', defaultContent: '' },   
            { data: 'product.barcode', title: '{{ __("backend.$routeNameData.barcode") }}' },   
            { data: 'name', title: '{{ __("backend.$routeNameData.name") }}' },   
            { data: 'type', title: '{{ __("backend.$routeNameData.type") }}' },   
            { data: 'size', title: '{{ __("backend.$routeNameData.size") }}' },   
            { data: 'amount', title: '{{ __("backend.$routeNameData.amount") }}' },   
            { data: 'stock', title: '{{ __("backend.$routeNameData.stock") }}' },   
            { data: 'created_at', title: '{{ __('created_at') }}' },
        ]
    });

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

    $('#form-search').submit(function(){
        table.draw();
    })

    $(`select[name='product_id[]']`).select2({        
        allowClear: true,
        placeholder: '{{ __("backend.$routeNameData.product_id") }}',					
        ajax: {
            url: '{{ route('backend.products.select') }}',
            type: "get",
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,				
                }
                return query;
            },
            processResults: function(data, page) {                								
                return { 
                    results: data.map(item => { return { 
                        id: item.id,
                        text: `${ item.name } ( ${ item.barcode } )`
                    } }) 
                }
            },
        }
    });
});
</script>
@endpush
