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
  var table = $('#dataTable').DataTable();
  table.columns( 0 ).search( "{{ $id ?? '' }}" ).draw();
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
  <h1 class="h3 mb-2 text-gray-800">Usuarios</h1>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Usuarios</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table data-order='[[ 0, "desc" ]]' class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr>
              <th>Id</th>
              <th>Cliente</th>
              <th>Fecha</th>
              <th>Id transacción</th>
              <th>Detalle</th>
            </tr>
          </thead>
          <tbody>
            @isset($sales)
            @foreach($sales as $sale)
            <tr>
              <td>{{$sale->id}}</td>
              <td>{{$sale->name}}</td>
              <td>{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y')}}</td>
              <td>{{$sale->paypal}}</td>
              <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detail{{$sale->id}}">
                  Ver
                </button></td>
            </tr>
            @endforeach
            @endisset
            @if(!count($sales))
            <td colspan="4" style="text-align:center">No se encontraron registros</td>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@isset($details)
@foreach($sales as $sale)
<!-- The Modal -->
<div class="modal fade" id="detail{{$sale->id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Detalle</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr>
              <th>Habitación</th>
              <th>Check in</th>
              <th>Check out</th>
              <th>Dias</th>
              <th>Precio</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($details[$sale->id] as $detail)
            <tr>
              <td>{{$detail->title}}</td>
              <td>{{ \Carbon\Carbon::parse($detail->check_in)->format('d/m/Y')}}</td>
              <td>{{ \Carbon\Carbon::parse($detail->check_out)->format('d/m/Y')}}</td>
              <td>{{$detail->days}}</td>
              <td>{{number_format($detail->price,0,'','.')}}</td>
              <td>{{number_format($detail->total,0,'','.')}}</td>
            </tr>
            @endforeach
            <tr>
              <th colspan="5" style="text-align:right">Total</th>
              <td>{{number_format($totals[$sale->id],0,'','.')}}</td>
            </tr>
            @if($details == null)
            <td colspan="4" style="text-align:center">No se encontraron registros</td>
            @endif
          </tbody>
        </table>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
@endforeach
@endisset
<!-- /.container-fluid -->
@endsection