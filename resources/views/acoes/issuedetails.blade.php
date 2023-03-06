@extends('layouts.layout')
@section('content')
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title">Issues</h3>
        <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        <span class="kt-subheader__desc">Details </span>
        <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        <span class="kt-subheader__desc">{{$issue->idissue}}</span>
    </div>
</div>


<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon"> <i class="kt-font-brand flaticon2-user"></i> </span>
                    <h3 class="kt-portlet__head-title"> Issue Details </h3>
                </div>
            </div>

            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                            <label><b>Issue Description</b></label>
                            <p>{{$issue->issueDescription}}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                            <label><b>Action</b></label>
                            <p>{{$issue->correctiveMeasure}}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                            <label><b>Input</b></label>
                            <p>{{$issue->name_input}}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                            <label><b>Department</b></label>
                            <p>{{$issue->name_department}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                            <label><b>Responsible</b></label>
                            <p>{{$issue->name_responsible}}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                            <label><b>Project/Location</b></label>
                            <p>{{$issue->name_localization}}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                            <label><b>Priority</b></label>
                            <p>{{$issue->number_priority}}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-3">
                        <div class="form-group">
                            <label><b>Situation</b></label>
                            <p>{{$issue->condition}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-sm-3">
                            <div class="form-group">
                                <label><b>Created By</b></label>
                                <p>{{$issue->createdby}}</p>
                            </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="card">
                    <!--begin::Accordion-->
                    <div class=" accordion accordion-toggle-plus" id="accordionExample1">
                        <div class="accordion-item accordion-collapse">
                            <div class="card ">
                                <div class="card-header" id="headingOne">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                                        Remarks Historic
                                    </div>
                                </div>
                                <div id="collapseOne1" class=" accordion-item collapse" aria-labelledby="headingOne" data-parent="#accordionExample1" style="">
                                    <div class="card-body">
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        Timeline
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="kt_widget2_tab1_content">
                                                        <!--Begin::Timeline 4 -->
                                                        <div class="kt-timeline-v3">
                                                        <div class="kt-timeline-v3__items">
                                                            @if (!$remarks->isEmpty())
                                                                @foreach($remarks as $remark)
                                                                    @if($remark->final==1 || $remark->final==2 )
                                                                        <div class="kt-timeline-v3__item kt-timeline-v3__item--warning">
                                                                    @else
                                                                        <div class="kt-timeline-v3__item kt-timeline-v3__item--info">
                                                                    @endif
                                                                            <span class="kt-timeline-v3__item-time" style="font-size:10px;">{{ date('Y-m-d H:i', strtotime($remark->created_at))}}</span>
                                                                            <div class="kt-timeline-v3__item-desc">
                                                                                <span class="kt-timeline-v3__item-text--dark kt-font-boldest">
                                                                                    @if($remark->final==1)
                                                                                        {{$remark->remarks}} -Cancelled
                                                                                    @elseif($remark->final==2)
                                                                                        {{$remark->remarks}} -Concluded
                                                                                    @else
                                                                                        {{$remark->remarks}}
                                                                                    @endif
                                                                                </span><br>
                                                                                <span class="kt-timeline-v3__item-user-name">
                                                                                    <a class="kt-link kt-link--dark kt-timeline-v3__item-link">
                                                                                        By  {{$remark->nome}}
                                                                                    </a>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                @endforeach
                                                            @else
                                                                <div class="kt-timeline-v3__item kt-timeline-v3__item--info">
                                                                    <span class="kt-timeline-v3__item-time" style="font-size:10px;">{{ date('Y-m-d', strtotime($issue->dtregister))}}</span>
                                                                    <div class="kt-timeline-v3__item-desc">
                                                                        <span class="kt-timeline-v3__item-text--dark kt-font-boldest">
                                                                            {{$issue->remarks}}
                                                                        </span><br>
                                                                        <span class="kt-timeline-v3__item-user-name">
                                                                            <a class="kt-link kt-link--dark kt-timeline-v3__item-link">
                                                                                Responsible  {{$issue->name_responsible}}
                                                                            </a>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                <!--End::Timeline 3 -->
                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Accordion-->
                </div>
            </div>
            <h3 class="kt-portlet__head-title">Dates:</h3>
            <div class="row">
                <div class="col-xl-3 col-sm-3">
                    <div class="form-group">
                        <label><b>Start Date</b></label>
                        <p>{{ date('Y-m-d', strtotime($issue->startDate))}}</p>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-3">
                    <div class="form-group">
                        <label><b>Preview Date</b></label>
                        <p>{{ date('Y-m-d', strtotime($issue->planDate))}}</p>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-3">
                    <div class="form-group">
                        <label><b>Forecast/End</b></label>
                        <p>{{ date('Y-m-d', strtotime($issue->endDate))}}</p>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-3">
                    <div class="form-group">
                        <label><b>Creation Date</b></label>
                        <p>{{ date('Y-m-d', strtotime($issue->dtregister))}}</p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__foot text-right">
        <div class="kt-form kt-padding-20 kt-form__actions">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</div>

</div>
@endsection
