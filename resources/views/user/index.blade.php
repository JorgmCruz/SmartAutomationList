@extends('layouts.layout')
@section('content')
@push('css')
<link href="../DataTables/datatables.min.css" rel="stylesheet" type="text/css" />

<style>
	.dataTables_length {
		margin-top: 25px;
	}

	table thead th:first-child {
            width: 10%;
        }
</style>



@endpush


<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title">Users</h3>
        <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        <span class="kt-subheader__desc">All Users</span>
		
    </div>
	
</div>


</div>

<!-- end:: Subheader -->

<!-- begin:: Content -->



<!-- begin:: Content -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">



@if(session()->has('message'))
	<div class="alert alert-success fade show" role="alert">
		<div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
		<div class="alert-text">{{ session()->get('message') }}</div>
		<div class="alert-close">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true"><i class="la la-close"></i></span>
			</button>
		</div>
	</div>
	@endif

	@if($errors->any())
	<div class="alert alert-danger fade show" role="alert">
		<div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
		<div class="alert-text">{{$errors->first()}}!</div>
		<div class="alert-close">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true"><i class="la la-close"></i></span>
			</button>
		</div>
	</div>
	@endif

	<div class="kt-portlet" style="border-style: none;">
		<div class="kt-portlet__head kt-portlet__head--lg">
			<div class="kt-portlet__head-label">
				<span class="kt-portlet__head-icon">
					<i class="kt-font-brand flaticon2-poll-symbol"></i>
				</span>
				<h3 class="kt-portlet__head-title">
					All Users
				</h3>
			</div>
			<div class="kt-portlet__head-toolbar">
				<div class="kt-portlet__head-wrapper">
					<a href="{{ url()->previous() }}" class="btn btn-clean btn-icon-sm">
						<i class="la la-long-arrow-left"></i>
						Back
					</a>
					&nbsp;


				</div>
			</div>
		</div>
		<div class="kt-portlet__body">

	

        {!! $dataTable->table([],true) !!}


			<!--end: Datatable -->
		</div>
	</div>


<!-- end:: Content -->








@push('scripts')
<script type="text/javascript" src="../DataTables/datatables.min.js"></script>


{!! $dataTable->scripts() !!}
@endpush
@endsection
