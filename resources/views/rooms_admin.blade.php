@extends ('layout_admin')

@section('meta')
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
  function message() {
    return confirm('Desea eliminar el registro');
  }
</script>
@endsection

@section('style')
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Habitaciones</h1>
  @if (session('error_')!==null)
  <div class="col-md-12 mb-3">
    <div class="alert alert-danger">
      <ul>
        <li>{{ session('error_') }}</li>
      </ul>
    </div>
  </div>
  @endif
  @if (session('success')!==null)
  <div class="col-md-12 mb-3">
    <div class="alert alert-success">
      <ul>
        <li>{{ session('success') }}</li>
      </ul>
    </div>
  </div>
  @endif
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Habitaciones</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nombre</th>
              <th>Precio</th>
              <th>Tipo</th>
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>Nombre</th>
              <th>Precio</th>
              <th>Tipo</th>
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($results as $result)
            <tr>
              <td>{{$result->id}}</td>
              <td>{{$result->title}}</td>
              <td>{{number_format($result->price,0,'','.')}}</td>
              <td>{{$result->name}}</td>
              <td><a href="{{route('rooms_admin.edit',[$result->id])}}">Editar</a></td>
              <td><a onclick="return message()" href="{{route('rooms_admin.destroy',[$result->id])}}">Eliminar</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
@endsection