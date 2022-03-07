@extends ('layout')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="description" content="check out" />
@endsection

@section('link')
@endsection

@section('title','STOREPY')

@section('script')
<script src="https://www.paypal.com/sdk/js?client-id=AWLN5cVOq9rSpM4sBut_g5RigSUBjhqaxRu4gDQo48nf4JMXym0GssefjQNoBK61lwUSsgXbrOB4B4u-"></script>
@if (session('user') !== null)
<script>
    var items = <?php echo json_encode($items); ?>;
    paypal.Buttons({
        createOrder: function(data, actions) {
            // This function sets up the details of the transaction, including the amount and line item details.
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '{{$total}}',
                        currency_code: 'USD',
                        breakdown: {
                            item_total: {
                                value: '{{$total}}',
                                currency_code: 'USD'
                            }
                        }
                    },
                    items: items
                }]
            });
        },
        onApprove: function(data, actions) {
            // This function captures the funds from the transaction.
            return actions.order.capture().then(function(details) {
                // This function shows a transaction success message to your buyer.
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('checkout.payment')}}",
                    method: "POST",
                    data: {
                        id: details.id,
                        email: details.payer.email_address
                    },
                    success: function(data) {
                        data === "completed" ? window.location.replace("{{route('profile')}}"):alert("Error al redireccionar");
                    }
                })
            });
        }
    }).render('#paypal-button-container')
</script>
@endif
@endsection

@section('style')
a[class="link_"] {
font-size: 12px;
font-weight: 600;
margin-bottom: 0;
color: #0315ff;
text-transform: uppercase;
margin-bottom: 10px;
}
@endsection

@section('content')
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Checkout Area Start ##### -->
<div class="checkout_area section-padding-80">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-5 ml-lg-auto m-auto">
                <div class="order-details-confirmation">

                    <div class="cart-page-heading">
                        <h5>Tus Reservas</h5>
                        <p>Detalles</p>
                    </div>

                    @if (!isset($results))
                    <div class="col-md-12 mb-3">
                        <div class="alert alert-danger">
                            <ul>
                                <li>El carrito de compras está vacío</li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    <ul class="order-details-form mb-4">
                        <li><span>Dias - Total</span><span>Habitacion</span></li>
                        @isset($results)
                        @foreach($results as $result)
                        @php
                        $check_in = new DateTime(session('check_in'.$result->id));
                        $check_out = new DateTime(session('check_out'.$result->id));
                        $interval = $check_in->diff($check_out);
                        $day = (int)$interval->days;
                        ($day !== 0)?:$day=1;
                        @endphp
                        <li><span>{{$day}} {{($day==1)?"Dia":"Dias"}} - ${{number_format(($day*((int)$result->price)),0,'','.')}}</span><span>{{$result->title}}</span></li>
                        @endforeach
                        @endisset
                        <li><span>Total</span> <span>${{number_format($total,0,'','.')}}</span></li>
                    </ul>
                    @if (session('user') === null)
                    Necesita <a class="link_" href="{{route('login')}}">iniciar sesión</a> para pagar.
                    @else
                    <div id="paypal-button-container"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Checkout Area End ##### -->
@endsection