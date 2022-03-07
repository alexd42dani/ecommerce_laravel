@extends ('layout')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('link')
@endsection

@section('title','STOREPY')

@section('script')
@endsection

@section('style')
a[class="activate"] {
display: block;
font-size: 12px;
font-weight: 600;
margin-bottom: 0;
color: #0315ff;
letter-spacing: 1.5px;
text-transform: uppercase;
margin-bottom: 10px;
}
@endsection

@section('content')
<div class="container col-md-4">
    <div class="row">

            <div class="col-md-12 mb-3 mt-3">
                <div class="mb-30" style="display:block;text-align:center">
                    <h3>Login</h3>
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

            <div class="col-md-12 mb-2">
                <a href="{{ route('login') }}" class="activate">Iniciar Sesión</a>
            </div>

    </div>
</div>
@endsection