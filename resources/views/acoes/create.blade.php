@extends('layouts.layout')
@section('content')
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title">Issues</h3>
        <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        <span class="kt-subheader__desc">Create Issue</span>
    </div>
</div>
@include('acoes.overlayinput')
@include('acoes.overlaydpto')
@include('acoes.overlaylocation')


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

<div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Create New Issue
                </h3>
            </div>
        </div>

        <!--begin::Form-->
        <form class="kt-form" id="kt_form_new" action="/acoes/store" method="POST" >
			@csrf
            <div class="kt-portlet__body">
                <div class="form-group form-group-last">
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                        <div class="alert-text">
                        Data, Input, Departament, Localization e Responsible are <b>mandatory</b> fields
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-6">
                        <div class="form-group">
                            <label>Issue description</label>
                            <textarea name="issueDescription" class="form-control" placeholder="Descrição Issue" required></textarea>
                            <span class="form-text text-muted">You must give a brief description of the Issue.</span>
                        </div>
                    </div>
                    <div class="col-6 col-6">
                        <div class="form-group">
                            <label>Corretive Action</label>
                            <textarea name="correctiveMeasure" class="form-control" placeholder="Ação Corretiva" required></textarea>
                            <span class="form-text text-muted">You must give a brief description of the corrective action.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Preview</label>
                            <input type="date" name="planDate" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                            <span class="form-text text-muted">Plan date.</span>
                        </div>
                    </div>
                    <div class="col-6 col-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Forecast/End</label>
                            <input type="date" name="endDate" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                            <span class="form-text text-muted">Real end date.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-6">
                        <div class="form-group">
                            <label>Input</label>

                            <select class="form-control kt-selectpicker" data-live-search="true" data-dropup-auto="false" name="input" tabindex="-98" required>
                                <option value=""> Select a Input</option>
                                <option value=""></option>
                            @foreach($inputs as $input)
                                <option value="{{$input->stored}}" >{{$input->stored}}</option>
                            @endforeach

                            </select>
                            @if(Auth::user()->permission==3)
                            <div class="kt-section__content">
                            <a onclick="onInput()" style="margin-top:10px; color:white; cursor:pointer;" class="btn btn-brand" data-toggle="kt-popover" title="Input" data-content="Add a new input , by clicking in this button." data-original-title="Popover title"><i class="flaticon2-add-1"></i></a>
                            </div>
                            @endif
                            <span class="form-text text-muted">You must select a input for the action.</span>
                        </div>
                    </div>
                    <div class="col-6 col-6">
                        <div class="form-group">
                            <label>Departament</label>
                            <select class="form-control kt-selectpicker" data-live-search="true" data-dropup-auto="false" name="department" tabindex="-98" required>
                                <option value=""> Select a Departament</option>
                                <option value=""></option>
                            @foreach($deps as $dep)
                                <option value="{{$dep->depto}}" >{{$dep->depto}}</option>
                            @endforeach
                            </select>
                            @if(Auth::user()->permission==3)
                            <div class="kt-section__content">
                            <a onclick="onDpto()" style="margin-top:10px; color:white; cursor:pointer;" class="btn btn-brand" data-toggle="kt-popover" title="Department" data-content="Add a new department , by clicking in this button." data-original-title="Popover title"><i class="flaticon2-add-1"></i></a>
                            </div>
                            @endif
                            <span class="form-text text-muted">You must select a department for the action.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-6">
                        <div class="form-group">
                            <label for="exampleSelect1">Priority</label>
                            <select name="priority" class="form-control" id="exampleSelect1" required>
                                <option value="TBD">TBD</option>
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                            <span class="form-text text-muted">You must select a priority for the action.</span>
                        </div>
                    </div>
                    <div class="col-6 col-6">
                        <div class="form-group">
                            <label>Location</label>

                            <select class="form-control kt-selectpicker" data-live-search="true" data-dropup-auto="false" name="location" tabindex="-98" required>
                                <option value=""> Select a Location</option>
                                <option value=""></option>
                            @foreach($locals as $local)
                                <option value="{{$local->nome_linha}}" >{{$local->nome_linha}}</option>
                            @endforeach

                            </select>
                            @if(Auth::user()->permission==3)
                            <div class="kt-section__content">
                            <a onclick="onLocal()" style="margin-top:10px; color:white; cursor:pointer;" class="btn btn-brand" data-toggle="kt-popover" title="Local" data-content="Add new location , by clicking in this button." data-original-title="Popover title"><i class="flaticon2-add-1"></i></a>
                            </div>
                            @endif
                            <span class="form-text text-muted">You must select a location for the action.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-6">
                        <div class="form-group">
                            <label>Responsible</label>

                            <select class="form-control kt-selectpicker" data-live-search="true" data-dropup-auto="false" name="responsible" tabindex="-98" required>
                                <option value=""> Select Responsible</option>
                                <option value=""></option>
                            @foreach($users as $user)
                                <option value="{{$user->Number}}" >{{$user->Name}}</option>
                            @endforeach

                            </select>
                            <span class="form-text text-muted">You must select a responsible for the action.</span>
                        </div>
                    </div>
                    <div class="col-6 col-6">
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control" placeholder="Remarks" required></textarea>
                            <span class="form-text text-muted">You must give a brief description of the remark.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <button type="submit" class="btn btn-primary submit_button">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>

</div>
@push('scripts')

<script>

	function onInput() {
		document.getElementById("overlayInput").style.display = "block";
	}

	function offInput() {
		document.getElementById("overlayInput").style.display = "none";
	}

    function onDpto() {
		document.getElementById("overlayDpto").style.display = "block";
	}

	function offDpto() {
		document.getElementById("overlayDpto").style.display = "none";
	}

    function onLocal() {
		document.getElementById("overlayLocal").style.display = "block";
	}

	function offLocal() {
		document.getElementById("overlayLocal").style.display = "none";
	}
</script>


@endpush

@endsection
