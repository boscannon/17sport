<div class="block-content block-content-full" style="100%">
    <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="data-table" style="width:100%">
        <thead>
        </thead>
    </table>
</div>

@push('scripts')
<style>
    .table.table-bordered{
        table-layout: fixed; 
        word-wrap:break-word; 
    }
    .table.table-bordered pre{
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>
<script>
$(function() {
    var path = '{{ route('backend.audits.index') }}';
    var tableList = $('#data-table');
    var formCreate = $('#form-create');
    var table = tableList.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        // scrollX: true,
        order: [[5, 'desc']],
        ajax: {
            url: path,
            data: {
                table: '{{ $table }}',
                table_id: '{{ $table_id }}',
            }            
        },
        columns: [
            { width: '5%', data: 'null', title: '#', bSearchable: false, bSortable: false, render: function ( data, type, row , meta ) {
                return  meta.row + 1;
            }},
            { width: '10%', data: 'user.name', title: '{{ __("backend.audits.user") }}' } ,
            { width: '10%', data: 'event', title: '{{ __("backend.audits.event") }}' } ,
            { width: '45%', data: 'auditing', title: '{{ __("backend.audits.auditing") }}', render: function ( data, type, row , meta ) {
                return `<pre style="margin: 0">${ data.join("\n") }</pre>`;
            } },          
            { width: '15%', data: 'created_at', title: '{{ __('created_at') }}' },
            { width: '15%', data: 'updated_at', title: '{{ __('updated_at') }}' },
        ]
    });

    $('.nav-tabs').on('shown.bs.tab', function (e) {
        table.columns.adjust().draw();
    });
});
</script>
@endpush
