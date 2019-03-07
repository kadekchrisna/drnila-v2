@extends('layouts.adminLayout.admin_design')
@section('content')
<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
    <h1>Welcome, {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}</h1>
  </div>
<!--End-breadcrumbs-->
  <div class="container-fluid">
    <div class="row-fluid">
        <p>Dashboard admin Dronila v1.0.</p>
        <hr>
    </div>
  </div>
</div>
@endsection