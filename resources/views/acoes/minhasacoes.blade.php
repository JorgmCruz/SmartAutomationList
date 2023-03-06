@extends('layouts.layout')
@section('content')
@push('css')
<link href="../DataTables/datatables.min.css" rel="stylesheet" type="text/css" />

<style>
	.dataTables_length {
		margin-top: 25px;
	}

	dataTables thead th:first-child {
            width: 5%;
        }
</style>

@endpush



@include('acoes.overlay')
@include('acoes.overlayconcluded')
@include('acoes.overlaycancelled')
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title">Issues</h3>
        <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        <span class="kt-subheader__desc">My Issues</span>
        <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        <div class="dropdown show">
            @if(Request::path() === 'acoes/minhasacoes/Processing')
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
            Processing
            </button>
            @elseif (Request::path() === 'acoes/minhasacoes/Concluded')
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
            Concluded
            </button>
            @elseif (Request::path() === 'acoes/minhasacoes/Cancelled')
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
            Cancelled
            </button>
            @elseif (Request::path() === 'acoes/minhasacoes/Todos')
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
			 All
            </button>
            @endif

        <div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 36px, 0px);">
            <button onclick="location.href='acoes/minhasacoes/Processing'" class="dropdown-item" type="button">Processing</button>
            <button onclick="location.href='acoes/minhasacoes/Concluded'" class="dropdown-item" type="button">Concluded</button>
            <button onclick="location.href='acoes/minhasacoes/Cancelled'" class="dropdown-item" type="button">Cancelled</button>
			<button onclick="location.href='acoes/minhasacoes/Todos'" class="dropdown-item" type="button">All</button>
        </div>
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
					My Issues
				</h3>
			</div>
			<div class="kt-portlet__head-toolbar">
				<div class="kt-portlet__head-wrapper">
					<a href="{{ url()->previous() }}" class="btn btn-clean btn-icon-sm">
						<i class="la la-long-arrow-left"></i>
						Back
					</a>
					&nbsp;
					<a href="/acoes/create" type="submit" class="btn btn-brand btn-icon-sm" aria-haspopup="true" style="color:white;">
						<i class="flaticon2-plus" style="color:white;"></i> Create Issue
					</a>


				</div>
			</div>
		</div>
		<div class="kt-portlet__body">

        {!! $dataTable->table([],true) !!}
			<!--end: Datatable -->
		</div>
	</div>
</div>

<!-- end:: Content -->
@push('scripts')
<script type="text/javascript" src="../DataTables/datatables.min.js"></script>
{!! $dataTable->scripts() !!}

<script>
	function on() {
		document.getElementById("overlay").style.display = "block";
	}

	function off() {
		document.getElementById("overlay").style.display = "none";
	}
</script>

<script>
	function onConc() {
		document.getElementById("overlayConc").style.display = "block";
	}

	function offConc() {
		document.getElementById("overlayConc").style.display = "none";
	}
</script>

<script>
	function onCanc() {
		document.getElementById("overlayCanc").style.display = "block";
	}

	function offCanc() {
		document.getElementById("overlayCanc").style.display = "none";
	}
</script>

<script>
	var table;
	$(document).ready(function() {
		table = $('#minhasacoes-datatable').DataTable();
	});

	$('body').on('click', '#actionBtt', function() {

		//obter informacao da linha que o utilizador clicou
		var row = table.row($(this).parents('tr')).data();

		//for row data
		console.log(row['idissue']);

		//dar valor
		$('#inputCod').val(row['idissue']);
		$('#inputCodConc').val(row['idissue']);
		$('#inputCodCanc').val(row['idissue']);

	});
</script>


@endpush
@endsection
