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
              <h1 class="h4 text-gray-900 mb-4">Agregar imagen!</h1>
            </div>
            @if (session('success')!==null)
            <div class="col-md-12 mb-3">
              <div class="alert alert-success">
                <ul>
                  <li>{{ session('success') }}</li>
                </ul>
              </div>
            </div>
            @endif
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
            <form method="POST" class="user" id="form_login" enctype="multipart/form-data" action="{{route('image.store')}}">
              @csrf
              <div class="form-group">
                <label for="myfile" style="padding-left:0.8rem">Selecciona una foto:</label>
                <input type="file" class="form-control form-control-user @error('photo') is-invalid @enderror" style="padding:1rem 0.5rem 2.3rem" id="photo" name="photo" required>
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