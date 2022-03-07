@extends ('layout_admin')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('link')
<link href='/packages/core/main.css' rel='stylesheet' />
<link href='/packages/daygrid/main.css' rel='stylesheet' />
@endsection

@section('title','Admin')

@section('script')
<script>
  $(document).ready(function() {
    $('#habi').on('change', function() {
      document.forms["form"].submit();
    });
  });
</script>
<script src='/packages/core/main.js'></script>
<script src='/packages/daygrid/main.js'></script>
<script src='/packages/core/locales/es.js'></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'es',
      plugins: ['dayGrid'],
      editable: false,
      eventLimit: true, // allow "more" link when too many events
      events: [<?php echo $item; ?>]
    });

    calendar.render();
  });
</script>
@endsection

@section('style')
<style>
  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }
</style>
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Calendario</h1>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Calendario</h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col">
          <form method="POST" class="user" id="form" name="form" action="{{route('calendar.index_')}}">
            @csrf
            <div class="form-group">
              <label for="habi">Habitación</label>
              <select class="w-100 form-control" name="habi" id="habi">
                <option value="">--Selecciona una opción--</option>
                @foreach($results as $result)
                @if ($id_selected == $result->id)
                <option selected value={{ $result->id }}>{{ $result->id." - ".$result->title }}</option>
                @else
                <option value={{ $result->id }}>{{ $result->id." - ".$result->title }}</option>
                @endif
                @endforeach
              </select>
            </div>
          </form>
        </div>
      </div>

      <div id='calendar'></div>

    </div>
  </div>

</div>
@endsection