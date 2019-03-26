@extends('layouts.frontLayout.front_design')
@section('content')

    <section id="slider"><!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($banners as $key => $banner)
                                <li data-target="#slider-carousel" data-slide-to="0" @if($key==0) class="active" @endif></li>
                            @endforeach
                        </ol>
                        
                        <div class="carousel-inner">
                            @foreach($banners as $key => $banner)
                            <div class="item @if($key==0) active @endif">
                                <a href="{{ $banner->link }}" title="Banner 1"><img src="img/frontend_img/banners/{{ $banner->image }}" ></a>
                            </div>
                            @endforeach
                        </div>
                        
                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section><!--/slider-->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Category</h2>
                        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                            <div class="panel panel-default">
                                @foreach ($categories as $cat)
                                    @if ($cat->status=="1")
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordian" href="#{{$cat->id}}">
                                                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                                    {{$cat->name}}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="{{$cat->id}}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul>
                                                    @foreach ($cat->categories as $subcat)
                                                        <li><a href="{{asset('/products/'.$subcat->name)}}">{{$subcat->name}} </a></li>
                                                    @endforeach
                                                    <li><a href="{{asset('/products/'.$cat->url)}}">All {{$cat->name}}</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div><!--/category-products-->
                    </div>
                </div>
                
                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">All Items</h2>
                        @foreach ($productsAll as $product)
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="{{ asset('img/backend_img/products/small/'.$product->image) }}" alt="" />
                                            <h2>USD {{$product->price}}</h2>
                                            <p>{{$product->product_name}}</p>
                                            <a href="{{url('/product/'.$product->id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>
                                        <!--<div class="product-overlay">
                                            <div class="overlay-content">
                                                <h2>USD {{$product->price}}</h2>
                                                <p>{{$product->product_name}}</p>
                                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                            </div>
                                        </div>-->
                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                </div>
            </div>
        </div>
    </section>

@endsection