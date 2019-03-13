
<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li class=""><a href="{{url('/admin/dashboard')}}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="submenu"> <a href="#"><i class="icon icon-tag"></i> <span>Categories</span> </a>
      <ul>
        <li><a href="{{url('/admin/add-category')}}">Add Category</a></li>
        <li><a href="{{url('/admin/view-category')}}">View Category</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-plane"></i> <span>Products</span></a>
      <ul>
        <li><a href="{{url('/admin/add-product')}}">Add Product</a></li>
        <li><a href="{{url('/admin/view-product')}}">View Product</a></li>
      </ul>
    </li>
  </ul>
</div>
<!--sidebar-menu-->
