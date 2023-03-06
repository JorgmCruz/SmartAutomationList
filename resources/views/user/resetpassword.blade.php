@extends('layouts.layout')
@section('content')
@push('css')
<link href="../DataTables/datatables.min.css" rel="stylesheet" type="text/css" />

<style>
	.dataTables_length {
		margin-top: 25px;
	}
</style>

<style>
.field-icon {
  float: right;
  margin-left: -25px;
  margin-top: -25px;
  margin-right:15px;
  position: relative;
  z-index: 2;
  cursor:pointer;
}

.container{
  padding-top:50px;
  margin: auto;
}
</style>
@endpush

<div class="kt-subheader   kt-grid__item" id="kt_subheader">


	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">
			User </h3>
		<span class="kt-subheader__separator kt-hidden"></span>
		<div class="kt-subheader__breadcrumbs">
			<a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
			<span class="kt-subheader__breadcrumbs-separator"></span>
			<a class="kt-subheader__breadcrumbs-link">
			{{ Auth::user()->name }} </a>
			<span class="kt-subheader__breadcrumbs-separator"></span>
			<a href="/user/changepassword/{{ Auth::user()->id}}" class="kt-subheader__breadcrumbs-link">
				Change Password </a>

			<!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
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
		<div class="alert-icon"><i class="flaticon2-close-cross"></i></div>
		<div class="alert-text">{{$errors->first()}}!</div>
		<div class="alert-close">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true"><i class="la la-close"></i></span>
			</button>
		</div>
	</div>
	@endif

	<!--begin::Portlet-->
	<div class="kt-portlet">
		<div class="kt-portlet__head">
			<div class="kt-portlet__head-label">
				<h3 class="kt-portlet__head-title">
					Change Password
				</h3>
			</div>
		</div>

		<!--begin::Form-->
		<form class="kt-form kt-form--label-right" method="post" action="/user/updatepassword" id="kt_form_1">
		@csrf
			<div class="kt-portlet__body">
				<div class="form-group form-group-last kt-hide">
					<div class="alert alert-danger" role="alert" id="kt_form_1_msg">
						<div class="alert-icon"><i class="flaticon-warning"></i></div>
						<div class="alert-text">
							Oh snap! Change a few things up and try submitting again.
						</div>
						<div class="alert-close">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="la la-close"></i></span>
							</button>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3 col-sm-12">Password *</label>
					<div class="col-lg-9 col-md-9 col-sm-12">
						<input id="password-field"  type="password" class="form-control" name="password" placeholder="Password">
						<input type="hidden" class="form-control" name="id"  value="{{Auth::user()->id}}" >
						<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
						<span class="form-text text-muted">You need to change your password, change to whatever you want.</span>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-3 col-sm-12">Confirma a password *</label>
					<div class="col-lg-9 col-md-9 col-sm-12">
					<input id="password-confirm" type="password" class="form-control" placeholder="Confirm your password." name="password_confirmation" >
						<span class="form-text text-muted">Please confirm your password.</span>
					</div>
				</div>


			</div>
			<div class="kt-portlet__foot">
				<div class="kt-form__actions">
					<div class="row">
						<div class="col-lg-9 ml-lg-auto">
						<button class="btn btn-primary" >Change Password</button>
							<button type="reset" class="btn btn-secondary">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<!--end::Form-->
	</div>


<!-- end:: Content -->








@push('scripts')
<script type="text/javascript" src="../DataTables/datatables.min.js"></script>
<script type="text/javascript">
	$.extend(true, $.fn.dataTable.defaults, {
		language: {
			url: '../js/Portuguese.json'
		}
	});
</script>

<script>
$(".toggle-password").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");

var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});

</script>

@endpush
@endsection
