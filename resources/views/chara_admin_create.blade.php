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
              <h1 class="h4 text-gray-900 mb-4">Caracteristica</h1>
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
            <form method="POST" class="user" id="form_login" action="{{route('chara_admin.store')}}">
              @csrf
              <div class="form-group">
                <input type="text" placeholder="Codigo" class="form-control form-control-user @error('id') is-invalid @enderror" id="id" name="id" value="{{ old('id') }}" readonly>
              </div>
              <div class="form-group">
                <input type="text" placeholder="Nombre" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
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