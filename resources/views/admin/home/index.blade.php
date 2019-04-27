@extends('layouts.admin')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ url('/payroll') }}"><i class="fa fa-home"></i> Home</a></li>
@endsection

@section('content-title')
    <h1><i class="fa fa-angle-double-right"></i> Dashboard</h1>
@endsection
@section('content')
@endsection

@push('styles')
<style type="text/css">

</style>
@endpush

@push('scripts')
<script type="text/javascript">
$(document).ready(function ($) {
   //
});
</script>
@endpush
