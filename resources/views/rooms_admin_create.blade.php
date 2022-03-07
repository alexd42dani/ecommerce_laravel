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

  function add() {
    var e = document.getElementById("chara");
    if (e.options[e.selectedIndex].value === "") {
      alert("Seleccionar caracteristica primero");
      return false;
    }
    var name_inputs = document.getElementsByName("input[]");
    for (let index = 0; index < name_inputs.length; index++) {
      const element = name_inputs[index];
      if (element.value == e.options[e.selectedIndex].value) {
        alert("Codigo ya ingresado");
        return false;
      }
    }
    table.row.add(
      [e.options[e.selectedIndex].value, e.options[e.selectedIndex].text,
        '<button type="button" class="btn btn-primary mx-auto" id="delete_row">Quitar</button>' +
        '<input type="hidden" name="input[]" value=' + e.options[e.selectedIndex].value + '>'
      ]
    ).draw();
    document.getElementById("chara").value = "";
  }
  $('#dataTable tbody').on('click', 'button#delete_row', function() {
    table
      .row($(this).parents('tr'))
      .remove()
      .draw();
  });
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

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg-7 mx-auto">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Crear una habitación!</h1>
            </div>
            @if ($errors->any())
            <div class="col-md-12 mb-3">
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
            @endif
            <form method="POST" class="user" id="form_login" enctype="multipart/form-data" action="{{route('rooms_admin.store')}}">
              @csrf
              <div class="form-group">
                <input type="text" placeholder="Nombre" class="form-control form-control-user @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
              </div>
              <div class="form-group">
                <textarea placeholder="Descripción" class="form-control form-control-user @error('description') is-invalid @enderror" id="description" name="description" required>{{ old('description') }}</textarea>
              </div>
              <div class="form-group">
                <input type="text" placeholder="Precio" class="form-control form-control-user @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
              </div>
              <div class="form-group">
                <label for="myfile" style="padding-left:0.8rem">Selecciona una foto:</label>
                <input type="file" class="form-control form-control-user @error('photo') is-invalid @enderror" style="padding:1rem 0.5rem 2.3rem" id="photo" name="photo" required>
              </div>
              <div class="form-group">
                <label for="myfile" style="padding-left:0.8rem">Selecciona segunda foto:</label>
                <input type="file" class="form-control form-control-user @error('photo1') is-invalid @enderror" style="padding:1rem 0.5rem 2.3rem" id="photo1" name="photo1" required>
              </div>
              <div class="form-group">
                <label for="nivel">Tipo de habitación</label>
                <select class="w-100 form-control" name="type" id="type">
                  <option value="">--Selecciona una opción--</option>
                  @foreach($types as $type)
                  <option value={{ $type->id }}>{{ $type->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="estado">Estado</label>
                <select class="w-100 form-control" name="estado" id="estado">
                  <option value="">--Selecciona una opción--</option>
                  <option value="0">Inactivo</option>
                  <option value="1" selected>Activo</option>
                </select>
              </div>
              <hr>
              <div class="form-group">
                <a href="" style="text-decoration:none;" data-toggle="modal" data-target="#modal_c"><i class="fas fa-plus-circle"></i> Agregar caracteristicas</a>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block">
                Registrar
              </button>

              <!-- The Modal -->
              <div class="modal fade" id="modal_c">
                <div class="modal-dialog">
                  <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Detalle</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="col-12 my-4">
                      <label for="chara">Caracteristicas</label>
                      <select class="w-100 form-control" id="chara">
                        <option value="">--Selecciona una opción--</option>
                        @foreach($characteristics as $characteristic)
                        <option value={{ $characteristic->id }}>{{ $characteristic->name }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-12">
                      <button type="button" class="btn btn-primary btn-user btn-block" onclick="add()">
                        Agregar
                      </button>
                    </div>

                    <!-- Modal body -->
                    <div class="col-12 my-4">
                      <div class="modal-body table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead class="thead-light">
                            <tr>
                              <th>Id</th>
                              <th>Caracteristica</th>
                              <th>Eliminar</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal" style="background-color:#4e73df;border-color:#4e73df">Cerrar</button>
                    </div>

                  </div>
                </div>
              </div>
              
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
@endsection