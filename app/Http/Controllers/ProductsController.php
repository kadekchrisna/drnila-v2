<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Auth;
use Image;
use Session;
use App\Category;
use App\Product;

class ProductsController extends Controller
{
    public function addProduct(Request $request){

		if ($request->isMethod('post')) {
			$data = $request->all();
			//echo "<pre>"; print_r($data); die;
			if (empty($data['category_id'])) {
				return redirect()->back()->with('flash_message_error', 'Under Category is missing!');
			}
			$product = new Product;
			$product->category_id = $data['category_id'];
			$product->product_name = $data['product_name'];
			$product->product_code = $data['product_code'];
			$product->product_color = $data['product_color'];
			if(!empty($data['description'])){
				$product->description = $data['description'];
			}else{
				$product->description = '';	
			}
			$product->price = $data['price'];

			//Upload Image
			if ($request->hasFile('image')) {
						$image_temp = Input::file('image');
						if ($image_temp->isValid()) {
								$extension = $image_temp->getClientOriginalExtension();

								$fileName = rand(111,99999).'.'.$extension;
								$large_image_path = 'img/backend_img/products/large/'.$fileName;
								$medium_image_path = 'img/backend_img/products/medium/'.$fileName;  
								$small_image_path = 'img/backend_img/products/small/'.$fileName;  

								Image::make($image_temp)->save($large_image_path);
								Image::make($image_temp)->resize(600, 600)->save($medium_image_path);
								Image::make($image_temp)->resize(300, 300)->save($small_image_path);
		 
								$product->image = $fileName; 
						}
			}
			$product->save();
			return redirect('/admin/view-product')->with('flash_message_success', 'Product has been added successfully');
		}
		
        $categories = Category::where(['parent_id' => 0])->get();

		$categories_drop_down = "<option value='' selected disabled>Select</option>";
		foreach($categories as $cat){
			$categories_drop_down .= "<option value='".$cat->id."'>".$cat->name."</option>";
			$sub_categories = Category::where(['parent_id' => $cat->id])->get();
			foreach($sub_categories as $sub_cat){
				$categories_drop_down .= "<option value='".$sub_cat->id."'>&nbsp;&nbsp;--&nbsp;".$sub_cat->name."</option>";	
			}	
		}

		//echo "<pre>"; print_r($categories_drop_down); die;

		return view('admin.products.add_products')->with(compact('categories_drop_down'));

	}
	
	public function editProducts(Request $request, $id = null){
		$productDetails = Product::where(['id'=>$id])->first();


        $categories = Category::where(['parent_id' => 0])->get();

		$categories_drop_down = "<option value='' selected disabled>Select</option>";
		foreach($categories as $cat){
			$categories_drop_down .= "<option value='".$cat->id."'>".$cat->name."</option>";
			$sub_categories = Category::where(['parent_id' => $cat->id])->get();
			foreach($sub_categories as $sub_cat){
				$categories_drop_down .= "<option value='".$sub_cat->id."'>&nbsp;&nbsp;--&nbsp;".$sub_cat->name."</option>";	
			}	
		}

		return view('admin.products.edit_products')->with(compact('productDetails','categories_drop_down'));
	}
		
	public function viewProducts(Request $request){
		$products = Product::get();
		$products = json_decode(json_encode($products));
		foreach ($products as $key => $value) {
			$category_name = Category::where(['id'=>$value->category_id])->first();
			$products[$key]->category_name = $category_name->name;
		}
		return view('admin.products.view_products')->with(compact('products'));
	
	}
}
