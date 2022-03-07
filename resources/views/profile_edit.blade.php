@extends ('layout')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('link')
@endsection

@section('title','Register')

@section('script')
<script>
    function check_pass() {
        var checkBox = document.getElementById("check");
        var text = document.getElementById("contraseña");
        var text1 = document.getElementById("r_contraseña");
        if (checkBox.checked == false) {
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
#login button:first-of-type{
margin-bottom:1.5rem!important;
}
/*#login a:first-child{
margin-bottom:1.5rem!important;
}
#login a:nth-of-type(1){
margin-bottom:1.5rem!important;
}*/
#form_login{
margin-top:9rem;
margin-bottom:3.5rem;
}
@endsection

@section('content')

<form method="POST" id="form_login" action="{{route('profile.update',$results[0]->id)}}">
    @csrf
    @method('PUT')
    <div class="container">
        <div class="row">

            <div id="login" class="row" style="margin:auto; border:1px solid #e8e8e8;">

                <div class="col-md-12 mb-3 mt-3">
                    <div class="mb-30" style="display:block;text-align:center">
                        <h5>Editar</h5>
                    </div>
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

                <div class="col-md-12 mb-3">
                    <label for="nya">Nombre</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value='{{explode(" ",$results[0]->name)[0]}}' required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="nya">Apellido</label>
                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value='{{explode(" ",$results[0]->name)[1]}}' required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="tel">Telefono</label>
                    <input type="text" class="form-control @error('tel') is-invalid @enderror" id="tel" name="tel" value="{{$results[0]->contact}}" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{$results[0]->address}}">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="email">Correo electrónico</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{$results[0]->email}}" readonly>
                </div>
                <div class="col-md-12 mb-3">
                    Editar contraseña: <input type="checkbox" id="check" onclick="check_pass()">
                </div>
                <div class="col-md-12 mb-4">
                    <label for="pass">Contraseña</label>
                    <input type="password" class="form-control @error('pass') is-invalid @enderror" id="contraseña" name="pass" value="{{ old('pass') }}" readonly>
                </div>
                <div class="col-md-12 mb-4">
                    <label for="rpass">Repetir Contraseña</label>
                    <input type="password" class="form-control @error('pass') is-invalid @enderror" id="r_contraseña" name="pass_confirmation" value="" readonly>
                </div>

                <div class="col-md-12 mb-2">
                    <button type="submit" class="btn essence-btn">Editar</button>
                </div>

            </div>

        </div>
    </div>
</form>
@endsection