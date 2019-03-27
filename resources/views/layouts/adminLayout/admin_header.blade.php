
<!--Header-part-->
<div id="header">
  <h1><a href="#">Dronila Admin</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li id="profile-messages" ><a title="" href="{{url('/admin/dashboard')}}d" ><i class="icon icon-user"></i>  <span class="text">Welcome, {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}</span></a>  </li>
    <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-shopping-cart"></i> <span class="text">Orders</span> <span class="label label-important">5</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sInbox" title="" href="#"><i class="icon icon-shopping-cart"></i>Orders Requests <span class="label label-important" style="margin-left: 5px;">5</span></a></li>
        <li><a class="sInbox" title="" href="#"><i class="icon icon-check"></i>Orders Completed</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="{{ url('/admin/setting') }}"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
    <li class=""><a title="" href="{{ url('/logout') }}"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->