@extends('layouts.layout')
@section('content')

<!-- begin:: Subheader -->


							<!-- end:: Subheader -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

  

    <!--input para o script vir buscar valores-->

    <div style="position: relative;  margin-top: 10%;"id="graph"></div>
  
    <input id="concluded" value="{{$conc}}" type="hidden">
    <input id="processing" value="{{$proc}}" type="hidden">
    <input id="delay" value="{{$delay}}" type="hidden">

    <div class="alert alert-outline-success" role="alert" style="width:25%;">
      <strong><a href="/acoes/minhasacoes/Concluded" class="kt-font-success" style="text-decoration: none;">My Concluded Issues</a></strong>
    </div>
    <div class="alert alert-outline-warning" role="alert" style="width:25%;">
      <strong><a href="/acoes/minhasacoes/Processing" class="kt-font-warning" style="text-decoration: none;">My Processing Issues</a></strong>
    </div>
    <span></span>
    <span></span>


</div>

@push('scripts')
<script>
//----------- Donut Total recuperados vs nao recuperados-------
Morris.Donut({
  element: 'graph',
  data: [
    {value: document.getElementById("concluded").value, label: 'Concluded'},
    {value: document.getElementById("processing").value, label: 'Processing'},
    {value: document.getElementById("delay").value, label: 'Delay'},
  ],
  backgroundColor: '#ccc',
  labelColor: '#000000',
  colors: [
    '#0BA462',
    '#FF8C00',
    '#DC143C',
  ],
});
</script>
@endpush
@endsection
