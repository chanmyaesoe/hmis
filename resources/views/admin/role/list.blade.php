@extends('layouts.admin')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('content-title')
    <h1><i class="fa fa-angle-double-right"></i> Roles</h1>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title mb-1 card-header-icon">
                    <i class="fa fa-lock"></i> Roles List
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.role.create') }}" class="btn btn-primary btn-sm">
                        <strong><i class="fa fa-plus"></i> Add Role</strong>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table_list table-striped table-bordered" id="list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role Name</th>
                            <th>Role Code</th>
                            <th>Created Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style type="text/css">
    #list {
        width: 100% !important;
    }
    .card-header .card-tools {
        position: absolute;
        right: 1rem;
        top: .5rem;
    }
</style>
@endpush

@push('scripts')
<script type="text/javascript">
var datatable;
$(document).ready(function ($) {
    datatable = $('#list').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csvHtml5',
                title: 'Role List',
                exportOptions: {
                    //columns: [0,1,2,3]
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Role List',
                exportOptions: {
                    //columns: [0,1,2,3]
                }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title: 'Role List',
                customize: function (doc) {
                    doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    doc.defaultStyle.alignment = 'left';
                    doc.styles.tableHeader.alignment = 'left';
                },
                exportOptions: {
                    //columns: [0,1,2,3]
                }
            }
        ],
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: {
            url:  "{!! route('admin.role.getData') !!}",
            type: "GET",
            headers: {
                'X-CSRF-TOKEN' : "{{ csrf_token() }}"
            },
        },
        ordering: true,
        columnDefs: [
            { orderable: false, targets: [0,-1] },
            { className: 'text-center', targets: '_all' },
        ],
        order: [[ 1, "asc" ]],
        searching: true,
        columns: [
            { "data" : null },
            { "data" : "name", "name" : "name" },
            { "data" : "code", "name" : "code" },
            { "data" : "created_at", "name" : "created_at" },
            { "data" : "action", "name" : "action" },
        ],
        language: {
            infoFiltered: "",
        },
        pageLength: 10,
        "createdRow": function (row, data, index) {
            var info = datatable.page.info();
            $('td', row).eq(0).html(index + 1 + info.page * info.length);
        },
    });
});

function confirmDelete(code, name)
{
    swal({
        title: "Confirmation",
        text: `Are you sure to remove ${name}?`,
        dangerMode: true,
        buttons: ['Cancel', 'Remove Role'],
        icon: "warning"
    }).then((response) => {
        if (response) {
            $("#page-loader").show();
            axios.post(`{{ url('/admin/role') }}/${code}`, {
                _method: 'delete'
            }).then(function (response) {
                //if (response.success) {
                if (response.status == 200) {
                    datatable.draw();
                    toastr.success(`${name} has been removed.`);
                }
            }).catch(function (exception) {
                var errors = exception.response.data.errors;
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        for (var errorId in errors[key]) {
                            toastr.error(errors[key][errorId]);
                        }
                    }
                }
            }).then(function () {
                $("#page-loader").hide();
            });
        }
    });
}
</script>
@endpush
