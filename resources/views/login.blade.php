@extends ('layout')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="description" content="login, register, registarse, iniciar session" />
<meta name="title" content="login, register, registarse, iniciar session" />
<meta name="keywords" content="login, register, registarse, iniciar session" />
@endsection

@section('link')
@endsection

@section('title','Login')

@section('script')
@endsection

@section('style')
a[class="link_login"] {
display: block;
font-size: 12px;
font-weight: 600;
margin-bottom: 0;
color: #0315ff;
letter-spacing: 1.5px;
text-transform: uppercase;
margin-bottom: 10px;
}
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

<form method="POST" id="form_login" action="{{route('login.auth')}}">
    @csrf
    <div class="container col-md-4">
        <div class="row">

            <div id="login" class="row" style="margin:auto; border:1px solid #e8e8e8;">

                <div class="col-md-12 mb-3 mt-3">
                    <div class="mb-30" style="display:block;text-align:center">
                        <h5>Login</h5>
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

                @if (isset($err))
                <div class="col-md-12 mb-3">
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ $err }}</li>
                        </ul>
                    </div>
                </div>
                @endif

                @if (isset($activate))
                <div class="col-md-12 mb-3">
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ $activate }}</li>
                        </ul>
                    </div>
                </div>
                @endif

                <div class="col-md-12 mb-3">
                    <label for="email">Correo electrónico</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-12 mb-4">
                    <label for="pass">Contraseña</label>
                    <input type="password" class="form-control @error('pass') is-invalid @enderror" id="pass" name="pass" value="{{ old('pass') }}" required>
                </div>

                <div class="col-md-12 mb-2">
                    <button type="submit" class="btn essence-btn">Iniciar Sesión</button>
                </div>

                <div class="col-md-12 mb-2">
                    <a href="#" class="link_login">¿Has olvidado la contraseña?</a>
                </div>

                <div class="col-md-12 mb-2">
                    <a href="{{ route('register') }}" class="link_login">Registrarse</a>
                </div>

            </div>

        </div>
    </div>
</form>
@endsection