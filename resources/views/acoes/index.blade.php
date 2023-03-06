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



@include('acoes.overlay')
@include('acoes.overlayconcluded')
@include('acoes.overlaycancelled')
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title">Issues</h3>
        <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        <span class="kt-subheader__desc">All Issues</span>
        <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        <div class="dropdown show">
            @if(Request::path() === 'acoes/all/Processing')
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
            Processing
            </button>
            @elseif (Request::path() === 'acoes/all/Concluded')
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
            Concluded
            </button>
            @elseif (Request::path() === 'acoes/all/Cancelled')
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
            Cancelled
            </button>
            @elseif (Request::path() === 'acoes/all/All')
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
			 All
            </button>
            @endif

        <div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 36px, 0px);">
            <button onclick="location.href='acoes/all/Processing'" class="dropdown-item" type="button">Processing</button>
            <button onclick="location.href='acoes/all/Concluded'" class="dropdown-item" type="button">Concluded</button>
            <button onclick="location.href='acoes/all/Cancelled'" class="dropdown-item" type="button">Cancelled</button>
			<button onclick="location.href='acoes/all/All'" class="dropdown-item" type="button">All</button>
        </div>

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

	<div class="kt-portlet" style="border-style: none;">
		<div class="kt-portlet__head kt-portlet__head--lg">
			<div class="kt-portlet__head-label">
				<span class="kt-portlet__head-icon">
					<i class="kt-font-brand flaticon2-poll-symbol"></i>
				</span>
				<h3 class="kt-portlet__head-title">
					All Issues
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

            <div class="row">
                <div class="col-xl-3 col-sm-3">
                    <div class="form-group">
                        <label>Select a Department</label>
                        <div class="dropdown bootstrap-select form-control">
                            <select id="name_department"  class="form-control selectpicker" data-live-search="true">
                                <option selected="selected"  value="0">Select a Department</option>
                                @foreach ($deps as $dep)
                                    <option value="{{$dep->depto}}">{{$dep->depto}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-3">
                    <div class="form-group">
                        <label>Select a input</label>
                        <div class="dropdown bootstrap-select form-control">
                            <select id="name_input"  class="form-control selectpicker" data-live-search="true">
                                <option value="0">Select a input</option>
                                @foreach ($inputs as $input)
                                    <option value="{{$input->stored}}">{{$input->stored}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-3">
                    <div class="form-group">
                        <label>Select a Location</label>
                        <div class="dropdown bootstrap-select form-control">
                            <select id="location"  class="form-control selectpicker" data-live-search="true">
                                <option value="0">Select a location</option>
                                @foreach ($locals as $local)
                                    <option value="{{$local->nome_linha}}">{{$local->nome_linha}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

		<button id="resetBtt" type="button" class="btn btn-secondary" style="width:21%; margin-bottom:10px;"><i class="fa fa-undo"></i> Reset</button>


        {!! $dataTable->table([],true) !!}


			<!--end: Datatable -->
		</div>
	</div>


<!-- end:: Content -->

@push('scripts')
<script type="text/javascript" src="../DataTables/datatables.min.js"></script>

{!! $dataTable->scripts() !!}

<script>

const table= $('#acoes-datatable');

table.on('preXhr.dt',function(e,settings,data){
	data.name_department=$('#name_department').val();
	data.name_input=$('#name_input').val();
    data.location=$('#location').val();


});

$('#name_department').on('change' , function(){
	//obter valor selecionado do dropdown on change
	var aux= document.getElementById("name_department").value;
	console.log(aux);
  // Store na sessao
  localStorage.setItem("name_department", aux);
table.DataTable().ajax.reload();
})

$('#name_input').on('change' , function(){

		//obter valor selecionado do dropdown on change
		var aux= document.getElementById("name_input").value;

console.log(aux);
// Store na sessao
localStorage.setItem("name_input", aux);

table.DataTable().ajax.reload();

})
$('#location').on('change' , function(){
    //obter valor selecionado do dropdown on change
    var aux= document.getElementById("location").value;
    console.log(aux);
    // Store na sessao
    localStorage.setItem("location", aux);
    table.DataTable().ajax.reload();
})
</script>
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
	var tables;
	$(document).ready(function() {
	document.getElementById("name_department").value =localStorage.getItem("name_department");
    console.log( localStorage.getItem("name_department"));
	document.getElementById("name_input").value =  localStorage.getItem("name_input");
    document.getElementById("location").value =localStorage.getItem("location");
    console.log( localStorage.getItem("location"));
    tables = $('#acoes-datatable').DataTable();
    $("#name_department").selectpicker('refresh');
    $("#name_input").selectpicker('refresh');
    $("#location").selectpicker('refresh');

    });

	$('body').on('click', '#actionBtt', function() {

		//obter informacao da linha que o utilizador clicou
		var row = tables.row($(this).parents('tr')).data();

		//for row data
		console.log(row['idissue']);

		//dar valor
		$('#inputCod').val(row['idissue']);
		$('#inputCodConc').val(row['idissue']);
		$('#inputCodCanc').val(row['idissue']);

	});
</script>

<script>
// Check browser support
if (typeof(Storage) !== "undefined") {

  // Retrieve
  document.getElementById("name_department").value = localStorage.getItem("name_department");
  document.getElementById("name_input").value = localStorage.getItem("name_input");
    document.getElementById("location").value = localStorage.getItem("location");
} else {
  document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
}

$( "#resetBtt" ).on( "click", function() {

	localStorage.removeItem("name_department");
	localStorage.removeItem("name_input");
    localStorage.removeItem("location");

	document.getElementById("name_department").value = "0";
	document.getElementById("name_input").value = "0";
    document.getElementById("location").value = "0";

    $("#name_department").selectpicker('refresh');
    $("#name_input").selectpicker('refresh');
    $("#location").selectpicker('refresh');

    table.DataTable().ajax.reload();


});



</script>
@endpush
@endsection
