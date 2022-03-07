@extends ('layout_admin')

@section('meta')
@endsection

@section('link')
@endsection

@section('title','Admin')

@section('script')

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
              <h1 class="h4 text-gray-900 mb-4">Crear una cuenta!</h1>
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
            <form method="POST" class="user" id="form_login" action="{{route('register_admin.store')}}">
              @csrf
              <div class="form-group">
                    <input type="text" placeholder="Nombre" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Apellido" class="form-control form-control-user @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                </div>
              <div class="form-group">
                <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email" value="{{ old('email') }}" required>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="password" class="form-control form-control-user @error('pass') is-invalid @enderror" id="contraseña" placeholder="Contraseña" name="pass" value="{{ old('pass') }}" required>
                </div>
                <div class="col-sm-6">
                  <input type="password" class="form-control form-control-user @error('pass') is-invalid @enderror" id="r_cntraseña" placeholder="Repetir contraseña" name="pass_confirmation" required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block">
                Registrar
              </button>
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