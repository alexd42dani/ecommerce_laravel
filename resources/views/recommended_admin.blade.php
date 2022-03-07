@extends ('layout_admin')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('link')
<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('title','Admin')

@section('script')
<!-- Page level plugins -->
<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="/js_admin/demo/datatables-demo.js"></script>
<script>
  $("body").delegate("input[id='check']","click",function(event){
    var path = '{{route("recommended.store")}}';
    var room = $(this).attr("id_room");
    var check_ =Number(this.checked);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: path,
        method: "POST",
        data: {
            id: room,
            check : check_
        }
        ,
        success: function (data) {
          if(data==1){
           alert("Habitación agregada a recomendados");
          }else{
            alert("Habitación eliminada de recomendados");

          }
        }
    })
})
</script>
@endsection

@section('style')
<style>
  table#dataTable tr {
    text-align: center;
  }
</style>
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Habitaciones</h1>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Habitaciones</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table data-order='[[ 0, "desc" ]]' class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr>
              <th>Id</th>
              <th>Habitación</th>
              <th>Tipo</th>
              <th>Precio</th>
              <th>Check</th>
            </tr>
          </thead>
          <tbody>
            @foreach($results as $result)
            <tr>
              <td>{{$result->id}}</td>
              <td>{{$result->title}}</td>
              <td>{{$result->name}}</td>
              <td>{{number_format($result->price,0,'','.')}}</td>
              <td><input type="checkbox" id="check" id_room="{{$result->id}}" {{$result->recommended===1?'checked':''}}></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection