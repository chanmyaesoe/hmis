@extends('layouts.admin')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ url('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Add Role</li>
@endsection

@section('content-title')
	<h1><i class="fas fa-angle-double-right"></i> Add Role Form</h1>
@endsection

@section('content')
<div id="app" class="row data-showcase">
    <div class="col-md-12">
        <div class="card card-info card-outline">
            <div class="card-header">
				<h3 class="card-title mb-1 card-header-icon">
					<i class="header-icon card-icon rounded-circle bg-dark fas fa-file-invoice-dollar"></i> Role Details
				</h3>
            </div>
            {!! form_start($form, ['id' => 'create_role_form']) !!}
            	<div class="card-body">
            		{!! form_row($form->name) !!}
                    {!! form_row($form->code) !!}
                	{!! form_row($form->description) !!}
            	</div>
            	<div class="card-footer text-right">
            		{!! form_row($form->register) !!}
            		<a href="#" onclick="confirmCancel()"  class="btn btn-link">Cancel</a>
            	</div>
			{!! form_end($form) !!}
        </div>
    </div>
</div>
@endsection
@push('styles')
	<style>
		label.required:after {
		    content: "* ";
		    color:red; 
        	padding-left:5px;
		}
	</style>
@endpush
@push('scripts')
	<script type="text/javascript">
		$(document).ready(function ($) {
		    $("#create_role_form").submit(function (e) {
		    	$("#create_role_btn").attr("disabled", true);
		    });
		});
		function confirmCancel() {
            swal({
                title: "Confirmation",
                text: "Cancel create allowance?",
                dangerMode: true,
                buttons: ['No', 'Yes'],
                icon: "warning"
            }).then((response) => {
                if (response) {
                    window.location = `{{ route('admin.role.index') }}`;
                }
            });
        }
	</script>
@endpush
