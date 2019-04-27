@extends('layouts.admin')

@section('breadcrumbs')
    <li class="breadcrumb-item"><i class="fa fa-home"></i> <a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">{{ $role->name }}</li> 
@endsection

@section('content')
<div class="row data-showcase" id="app">
    <div class="col-md-12">
        <form action="{{ route('admin.role.update', ['code' => $role->code]) }}" method="POST">
            @method('PATCH')
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title mb-0 card-header-icon">
                        <i class="header-icon card-icon rounded-circle bg-dark fas fa-file-invoice-dollar"></i>
                    </h3>
                    <div class="card-tools">
                        <h1>Role Details</h1>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Code</label>
                                <div class="control-data">
                                   <span>{{$role->code}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <div class="control-data">
                                    <span>{{$role->name}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <div class="control-data">
                                    <span>{{$role->description}}</span>
                                </div>
                            </div>
                        </div>
                        @if ($role->created_at)
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Created At</label>
                                <div class="control-data">
                                    @include('components.molecules.calendar', ['date' => $role->created_at])
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($role->updated_at)
                        <div id="modified-at" class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Modified At</label>
                                <div class="control-data">
                                    @include('components.molecules.calendar', ['date' => $role->updated_at])
                                </div>
                            </div>
                        </div>
                        @else
                        <div id="modified-at" class="col-lg-6" style="display:none;">
                            <div class="form-group">
                                <label class="control-label">Modified At</label>
                                <div class="control-data">
                                    @include('components.molecules.calendar', ['date' => $role->created_at])
                                </div>
                            </div>
                        </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    
@endpush