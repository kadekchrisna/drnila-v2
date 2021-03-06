@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ url('/admin/view-product')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">View Products</a> </div>
      <h1>Products</h1>
      @if(Session::has('flash_message_error'))
      <div class="alert alert-error alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{!! session('flash_message_error') !!}</strong>
      </div>
      @endif   
      @if(Session::has('flash_message_success'))
          <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
                  <strong>{!! session('flash_message_success') !!}</strong>
          </div>
      @endif
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Products</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="table-responsive">
                    <table class="table table-bordered data-table">
                        <thead>
                        <tr>
                            <th>Products ID</th>
                            <th>Category Name</th>
                            <th>Products Name</th>
                            <th>Products Code</th>
                            <th>Products Color</th>
                            <th>Price</th>
                            <th>Image Product</th>
                            <th>Image Pilot</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="gradeX">
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->category_name}}</td>
                                    <td>{{$product->product_name}}</td>
                                    <td>{{$product->product_code}}</td>
                                    <td>{{$product->product_color}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>
                                        @if(!empty($product->image))
                                        <img class="align-middle" src="{{ asset('/img/backend_img/products/small/'.$product->image) }}" style="width:50px;">
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($product->image_pilot))
                                        <img class="align-middle" src="{{ asset('/img/backend_img/products/small/'.$product->image_pilot) }}" style="width:50px;">
                                        @endif
                                    </td>
                                <td class="center"> <a href="#myModal{{$product->id}}" title="View Product" data-toggle="modal" class="btn btn-success btn-mini">View</a> <a href="{{url('/admin/edit-rent/'.$product->id)}}" title="Edit Product" class="btn btn-primary btn-mini">Edit</a> <a href="{{url('/admin/add-attributes/'.$product->id)}}" title="Add Product Attribute" class="btn btn-success btn-mini">Add</a> <a href="{{url('/admin/add-images/'.$product->id)}}" title="Add Product Image" class="btn btn-info btn-mini">Add</a> <a rel="{{ $product->id }}" title="Delete Product" rel1="delete-product" id="delCat" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a></td>
                                </tr>
                                <div id="myModal{{$product->id}}" class="modal hide">
                                <div class="modal-header">
                                    <button data-dismiss="modal" class="close" type="button">×</button>
                                    <h3>Pop up Header</h3>
                                </div>
                                <div class="modal-body">
                                    <p>Products ID: {{$product->id}}</p>
                                    <p>Category ID: {{$product->category_id}}</p>
                                    <p>Category Name: {{$product->category_name}}</p>
                                    <p>Products Name: {{$product->product_name}}</p>
                                    <p>Products Code: {{$product->product_code}}</p>
                                    <p>Products Color: {{$product->product_color}}</p>
                                    <p>Spec: </p>
                                    <p>Price: {{$product->price}}</p>
                                    <p>Description: {{$product->description}}</p>
                                    <p>Image Product: 
                                        @if(!empty($product->image))
                                        <img class="align-middle" src="{{ asset('/img/backend_img/products/small/'.$product->image) }}" style="width:50px;">
                                        @endif
                                    <p>
                                    <p>Image Pilot: 
                                            @if(!empty($product->image_pilot))
                                            <img class="align-middle" src="{{ asset('/img/backend_img/products/small/'.$product->image_pilot) }}" style="width:50px;">
                                            @endif
                                        <p>
                                </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection