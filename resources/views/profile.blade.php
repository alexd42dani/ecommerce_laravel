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
.link {
display: block;
font-size: 12px;
font-weight: 600;
margin-bottom: 0;
color: #0315ff;
letter-spacing: 1.5px;
text-transform: uppercase;
margin-bottom: 10px;
}
.link_btn {
display: block;
font-size: 12px;
font-weight: 600;
margin-bottom: 0;
color: #ffffff;
letter-spacing: 1.5px;
text-transform: uppercase;
margin-bottom: 10px;
}
table#dataTable tr{
    text-align:center;
  }
@endsection

@section('content')
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Perfil de usuario</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Checkout Area Start ##### -->
<div class="checkout_area section-padding-80">
    <div class="container" style="margin-left: 0%">
        <div class="row">

            <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                <div class="order-details-confirmation">

                    <div class="cart-page-heading">
                        <h5>Perfil</h5>
                        @isset($results)
                        <ul class="order-details-form mb-4">
                            <li><span>Detalle</span> <span><a href="{{route('profile.edit')}}" class="link">Editar</a></span></li>
                        </ul>
                        <p>{{$results[0]->name}}</p>
                        <p>{{$results[0]->email}}</p>
                        <p>{{$results[0]->address}}</p>
                        <p>{{$results[0]->contact}}</p>
                        @endisset
                    </div>

                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="checkout_details_area mt-30 clearfix">

                    @if (session('success')!==null)
                    <div class="col-md-12 mb-3">
                        <div class="alert alert-success">
                            <ul>
                                <li>{{ session('success') }}</li>
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div class="cart-page-heading mb-30">
                        <h5 style="text-align:center">Historial de transacciones</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
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
                                    <td>{{$results[0]->name}}</td>
                                    <td>{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y')}}</td>
                                    <td>{{$sale->paypal}}</td>
                                    <td><button type="button" class="link_btn btn btn-primary" data-toggle="modal" data-target="#detail{{$sale->id}}">
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
<!-- ##### Checkout Area End ##### -->
@endsection