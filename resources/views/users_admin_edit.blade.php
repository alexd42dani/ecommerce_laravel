@extends ('layout_admin')

@section('meta')
@endsection

@section('link')
@endsection

@section('title','Admin')

@section('script')
<script>
function check_pass() {
  var checkBox = document.getElementById("check");
  var text = document.getElementById("contraseña");
  var text1 = document.getElementById("r_contraseña");
  if (checkBox.checked == false){
    text.readOnly = true; 
    text1.readOnly = true; 
  } else {
    text.readOnly = false; 
    text1.readOnly = false; 
  }
}
</script>
@endsection

@section('style')
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
              <h1 class="h4 text-gray-900 mb-4">Editar</h1>
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
            <form method="POST" class="user" id="form_login" action="{{route('users_admin.update',$results[0]->id)}}">
              @csrf
              @method('PUT')
              <div class="form-group">
                    <input type="text" placeholder="Nombre" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" name="name" value='{{explode(" ",$results[0]->name)[0]}}' required>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Apellido" class="form-control form-control-user @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value='{{explode(" ",$results[0]->name)[1]}}' required>
                </div>
              <div class="form-group">
                <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email" value="{{$results[0]->email}}" readonly>
              </div>
              <div class="form-group">
              Editar contraseña: <input type="checkbox" id="check" onclick="check_pass()">
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="password" class="form-control form-control-user @error('pass') is-invalid @enderror" id="contraseña" placeholder="Contraseña" name="pass" value="{{ old('pass') }}" readonly>
                </div>
                <div class="col-sm-6">
                  <input type="password" class="form-control form-control-user @error('pass') is-invalid @enderror" id="r_contraseña" placeholder="Repetir contraseña" name="pass_confirmation" readonly>
                </div>
              </div>
              <div class="form-group">
                <label for="estado">Estado</label>
                <select class="w-100 form-control" name="estado" mid="estado">
                  <option value="">--Selecciona una opción--</option>
                  <option value="0" {{($results[0]->status!==0)?"":"selected"}}>Inactivo</option>
                  <option value="1" {{($results[0]->status!==1)?"":"selected"}}>Activo</option>
                </select>
              </div>
              <div class="form-group">
                <label for="nivel">Nivel</label>
                <select class="w-100 form-control" name="nivel" id="nivel">
                  <option value="">--Selecciona una opción--</option>
                  <option value="0" {{($results[0]->level!==0)?"":"selected"}}>Admin</option>
                  <option value="1" {{($results[0]->level!==1)?"":"selected"}}>Super Admin</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block">
                Registrarse
              </button>
            </form>
            <hr>
            <div class="text-center">
              <a class="small" href="{{route('login_admin')}}">¿Ya tienes una cuenta?</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
@endsection