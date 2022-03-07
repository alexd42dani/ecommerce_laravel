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
#selected{
    font-weight:600;
    color:#363434";
}
@endsection

@section('content')
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Habitaciones</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Shop Grid Area Start ##### -->
<section class="shop_grid_area section-padding-80">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3">
                <div class="shop_sidebar_area">

                    <!-- ##### Single Widget ##### -->
                    <div class="widget catagory mb-50">
                        <!-- Widget Title -->
                        <h6 class="widget-title mb-30">Categorias</h6>

                        <!--  Catagories  -->
                        <div class="catagories-menu">
                            <ul id="menu-content2" class="menu-content collapse show">
                                <!-- Single Item -->
                                <li data-toggle="collapse" data-target="#clothing">
                                    <a href="#">Tipos de habitación</a>
                                    <ul class="sub-menu collapse show" id="clothing">
                                        <li><a href="{{route('shop')}}" id={{$nro_type==null?"selected":''}}>Todos</a></li>
                                        @foreach($types as $type)
                                        <li><a href="{{route('shop',['type'=>$type->id])}}" id={{$nro_type==$type->id?"selected":''}}>{{$type->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 col-md-8 col-lg-9">
                <div class="shop_grid_product_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="product-topbar d-flex align-items-center justify-content-between">
                                <!-- Total Products -->
                                <div class="total-products">
                                    <p><span>{{$count}}</span> Habitaciones encontradas</p>
                                </div>
                                <!-- Sorting -->
                                <div class="product-sorting d-flex">
                                    <p>Ordenar por:</p>
                                        <select name="select" id="sortByselect" name="order" onchange="location = this.value;">
                                            <option value="{{route('shop')}}?page={{$selected}}&type={{$nro_type==null?'':$nro_type}}&order=1" {{$order!=="1"?'':"selected"}}>Antiguas</option>
                                            <option value="{{route('shop')}}?page={{$selected}}&type={{$nro_type==null?'':$nro_type}}&order=2" {{$order!=="2"?'':"selected"}}>Nuevas</option>
                                            <option value="{{route('shop')}}?page={{$selected}}&type={{$nro_type==null?'':$nro_type}}&order=3" {{$order!=="3"?'':"selected"}}>Menor Precio</option>
                                            <option value="{{route('shop')}}?page={{$selected}}&type={{$nro_type==null?'':$nro_type}}&order=4" {{$order!=="4"?'':"selected"}}>Mayor Precio</option>
                                        </select>
                
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        @foreach($results as $result)

                        <!-- Single Product -->
                        <div class="col-12 col-sm-6 col-lg-4" style="margin-top:auto">
                            <div class="single-product-wrapper">
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
                <!-- Pagination -->
                <nav aria-label="navigation">
                    <ul class="pagination mt-50 mb-70">
                        <li class="page-item"><a class="page-link" href="{{route('shop',['page'=>'1'])}}&type={{$nro_type==null?'':$nro_type}}&order={{$order==null?'':$order}}"><i class="fa fa-angle-left"></i></a></li>
                        @for($i=0; $i<$pages;$i++) <li class="page-item"><a class="page-link" href="{{route('shop')}}?page={{$i+1}}&type={{$nro_type==null?'':$nro_type}}&order={{$order==null?'':$order}}" style={{$selected===$i+1?"color:#363434;font-size:101%;":''}}>{{$i+1}}</a></li>
                            @endfor
                            <li class="page-item"><a class="page-link" href="{{route('shop')}}?page={{$pages}}&type={{$nro_type==null?'':$nro_type}}&order={{$order==null?'':$order}}"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ##### Shop Grid Area End ##### -->
@endsection