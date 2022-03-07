@extends ('layout')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="description" content="{{$rooms[0]->description}}" />
<meta name="title" content="{{$rooms[0]->title}}"/>
@endsection

@section('link')
@endsection

@section('title','STOREPY')

@section('script')
@endsection

@section('style')
@endsection

@section('content')
<!-- ##### Single Product Details Area Start ##### -->
<section class="single_product_details_area d-flex align-items-center">

    <!-- Single Product Thumb -->
    <div class="single_product_thumb clearfix">
        <div class="product_thumbnail_slides owl-carousel">
            <img src="/img/product-img/{{$rooms[0]->photo}}" alt="">
            <img src="/img/product-img/{{$rooms[0]->photo1}}" alt="">
        </div>
    </div>
    <!-- Single Product Description -->
    <div class="single_product_desc clearfix">
        <span>{{$rooms[0]->room_type}}</span>
        <a href="#">
            <h2>{{$rooms[0]->title}}</h2>
        </a>
        <p class="product-price"> ${{number_format($rooms[0]->price,0,'','.')}}</p>
        <p class="product-desc">{{$rooms[0]->description}}</p>

        <!-- Form -->
        <form class="cart-form clearfix" method="post">
            <div class="row">
                <div class="col-6">
                    <div class="select-box d-flex mt-50">
                        <label for="check_in" style="display:block;">Entrada</label>
                    </div>
                    <div class="select-box d-flex mb-30">
                        <input type="date" style="margin-right:10%" name="check_in" id="check_in" value="{{\Carbon\Carbon::now(new DateTimeZone('America/Asuncion'))->format('Y-m-d')}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="select-box d-flex mt-50">
                        <label for="check_out" style="display:block;">Salida</label>
                    </div>
                    <div class="select-box d-flex mb-30">
                        <input type="date" name="check_out" id="check_out" value="{{\Carbon\Carbon::tomorrow(new DateTimeZone('America/Asuncion'))->format('Y-m-d')}}">
                    </div>
                </div>
            </div>
            <!-- Cart & Favourite Box -->
            <div class="col-md mb-2" id="message">
            </div>
            <div class="cart-fav-box d-flex align-items-center mt-50">
                <!-- Cart -->
                <button type="submit" id="addtocart" path="{{route('cart.add')}}" room="{{$rooms[0]->id}}" name="addtocart" class="btn essence-btn">Reservar</button>
            </div>
        </form>
        <div class="select-box d-flex mt-50 mb-30 row">
            @foreach($characteristics as $charact)
            <div class="col-6">
                <span class="mb-4">{{$charact->name}}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- ##### Single Product Details Area End ##### -->
@endsection