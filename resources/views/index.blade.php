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

@endsection

@section('content')
<!-- ##### Welcome Area Start ##### -->
<section class="welcome_area bg-img background-overlay" style="background-image: url(img/bg-img/{{$photo[0]->name}});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="hero-content" style="text-align:center">
                    <h6 style="color:#fff">TRAVELPY</h6>
                    <h2>Reservas</h2>
                    <a href="{{route('shop')}}" class="btn essence-btn">Ver Habitaciónes</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Welcome Area End ##### -->

<!-- ##### New Arrivals Area Start ##### -->
<section class="new_arrivals_area section-padding-80 clearfix" style="padding-bottom:0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center" style="margin-bottom:0">
                    <h2>Recomendados</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="popular-products-slides owl-carousel">

                    @foreach($results as $result)
                    <div style="display: flex;height:350px">
                        <div class="single-product-wrapper" style="align-self: flex-end;">
                            <!-- Product Image -->
                            <div class="product-img">
                                <img src="img/product-img/{{$result->photo}}" alt="">
                            </div>

                            <!-- Product Description -->
                            <div class="product-description">
                                <span>{{$result->room_type}}</span>
                                <a href="{{route('shop.detail',["$result->id"])}}">
                                    <h6>{{$result->title}}</h6>
                                </a>
                                <p class="product-price">${{number_format($result->price,0,'','.')}}</p>

                                <!-- Hover Content -->
                                <div class="hover-content">
                                    <!-- Add to Cart -->
                                    <div class="add-to-cart-btn">
                                        <a href="{{route('shop.detail',["$result->id"])}}" class="btn essence-btn">Ver</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### New Arrivals Area End ##### -->
@endsection