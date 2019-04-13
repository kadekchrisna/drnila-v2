<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Auth;
use Image;
use Session;
use App\Category;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Rent;
use DB; 

class RentsController extends Controller
{
    public function addProductRent(Request $request){

		if ($request->isMethod('post')) {
			$data = $request->all();
			//echo "<pre>"; print_r($data); die;
			if (empty($data['category_id'])) {
				return redirect()->back()->with('flash_message_error', 'Under Category is missing!');
			}elseif (!$request->hasFile('image')) {
				return redirect()->back()->with('flash_message_error', 'Please Add Image! ');
			}
			$product = new Rent;
			$product->category_id = $data['category_id'];
			$product->product_name = $data['product_name'];
			$product->product_code = $data['product_code'];
			$product->product_color = $data['product_color'];
			if(!empty($data['description'])){
				$product->description = $data['description'];
			}else{
				$product->description = '';	
			}if(!empty($data['care'])){
				$product->care = $data['care'];
			}else{
				$product->care = '';	
			}
            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
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
            //Upload Image Pilot
			if ($request->hasFile('image_pilot')) {
				$image_temp = Input::file('image_pilot');
				if ($image_temp->isValid()) {
						$extension = $image_temp->getClientOriginalExtension();

						$fileName = rand(111,99999).'.'.$extension;
						$large_image_path = 'img/backend_img/products/large/'.$fileName;
						$medium_image_path = 'img/backend_img/products/medium/'.$fileName;  
						$small_image_path = 'img/backend_img/products/small/'.$fileName;  

						Image::make($image_temp)->save($large_image_path);
						Image::make($image_temp)->resize(600, 600)->save($medium_image_path);
						Image::make($image_temp)->resize(300, 300)->save($small_image_path);
 
						$product->image_pilot = $fileName; 
				}
			}
			$product->save();
			return redirect('/admin/view-rent')->with('flash_message_success', 'Product has been added successfully');
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

		return view('admin.rents.add_rents')->with(compact('categories_drop_down'));

	}
	
	public function editProductsRent(Request $request, $id = null){

		if ($request->isMethod('post')) {
			$data = $request->all();
			//echo "<pre>"; print_r($data); die;

            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }
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
 
						
				}
			}else {
				$fileName = $data['current_image'];
            }
			
            //Upload Image Pilot
			if ($request->hasFile('image_pilot')) {
				$image_temp = Input::file('image_pilot');
				if ($image_temp->isValid()) {
						$extension = $image_temp->getClientOriginalExtension();

						$fileNamePilot = rand(111,99999).'.'.$extension;
						$large_image_path = 'img/backend_img/products/large/'.$fileNamePilot;
						$medium_image_path = 'img/backend_img/products/medium/'.$fileNamePilot;  
						$small_image_path = 'img/backend_img/products/small/'.$fileNamePilot;  

						Image::make($image_temp)->save($large_image_path);
						Image::make($image_temp)->resize(600, 600)->save($medium_image_path);
						Image::make($image_temp)->resize(300, 300)->save($small_image_path);
 
				}
			}else {
				$fileNamePilot = $data['current_image_pilot'];
            }
            
            if(empty($data['description'])){
            	$data['description'] = '';
            }

            if(empty($data['care'])){
                $data['care'] = '';
            }

			Rent::where(['id'=>$id])->update(['status'=>$status,'category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
				'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],'care'=>$data['care'],'price'=>$data['price'],'image'=>$fileName,'image_pilot'=>$fileNamePilot]);
			return redirect()->back()->with('flash_message_success', 'Product has been updated successfully');
		}
		$productDetails = Rent::where(['id'=>$id])->first();

        $categories = Category::where(['parent_id' => 0])->get();

		$categories_drop_down = "<option value='' selected disabled>Select</option>";
		foreach($categories as $cat){
			if ($cat->id==$productDetails->category_id) {
				$selected = "selected";
			}else{
				$selected = "";
			}
			$categories_drop_down .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
			$sub_categories = Category::where(['parent_id' => $cat->id])->get();
			foreach($sub_categories as $sub_cat){
				if ($sub_cat->id==$productDetails->category_id) {
					$selected = "selected";
				}else{
					$selected = "";
				}
				$categories_drop_down .= "<option value='".$sub_cat->id."' ".$selected.">&nbsp;&nbsp;--&nbsp;".$sub_cat->name."</option>";	
			}	
		}

		return view('admin.rents.edit_rents')->with(compact('productDetails','categories_drop_down'));
	}
		
	public function viewProductsRent(Request $request){
		$products = Rent::get();
		$products = json_decode(json_encode($products));
		foreach ($products as $key => $value) {
			$category_name = Category::where(['id'=>$value->category_id])->first();
			$products[$key]->category_name = $category_name->name;
		}
		return view('admin.rents.view_rents')->with(compact('products'));
	
	}
	public function deleteProductRentImage($id = null){
        
        // Get Product Image
		$productImage = Product::where('id',$id)->first();

		// Get Product Image Paths
		$large_image_path = 'img/backend_img/products/large/';
		$medium_image_path = 'img/backend_img/products/medium/';
		$small_image_path = 'img/backend_img/products/small/';
		// Delete Large Image if not exists in Folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        // Delete Medium Image if not exists in Folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        // Delete Small Image if not exists in Folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

		Product::where(['id'=>$id])->update(['image'=>'']);
		return redirect()->back()->with('flash_message_success', 'Product Image has been deleted successfully');


	}
	public function deleteProductRent($id = null){
		Product::where(['id'=>$id])->delete();
		return redirect()->back()->with('flash_message_success', 'Product has been deleted successfully');
    }
    public function addAttributes(Request $request, $id = null){
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();

      

        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach($data['sku'] as $key => $val){
                if(!empty($val)){

                    $attrCountSKU = ProductsAttribute::where(['sku'=>$val])->count();
                    if($attrCountSKU>0){
                        return redirect('admin/add-attributes/'.$id)->with('flash_message_error', 'SKU already exists. Please add another SKU.');    
                    }
                    $attrCountSizes = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if($attrCountSizes>0){
                        return redirect('admin/add-attributes/'.$id)->with('flash_message_error', 'Size '.$data['size'][$key].' already exists. Please add another Attribute.');    
                    }
                    $attributes = new ProductsAttribute;
                    $attributes->product_id = $id;
                    $attributes->sku = $val;
                    $attributes->size = $data['size'][$key];
                    $attributes->price = $data['price'][$key];
                    $attributes->stock = $data['stock'][$key];
                    $attributes->save();
                }
            }
            return redirect('admin/add-attributes/'.$id)->with('flash_message_success', 'Product Attributes has been added successfully');
        }

        return view('admin.products.add_attributes')->with(compact('productDetails'));
    }

    public function editAttributes (Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            foreach($data['idAttr'] as $key=> $attr){
                if(!empty($attr)){
                    ProductsAttribute::where(['id' => $data['idAttr'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
                }
            }
            return redirect('admin/add-attributes/'.$id)->with('flash_message_success', 'Product Attributes has been updated successfully');
        }
    }

    public function deleteAttribute($id = null){
        ProductsAttribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product Attributes has been deleted successfully');

    }

    public function productsRent($url = null){
        // Show 404 Page if Category does not exists
    	$categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
    	if($categoryCount==0){
    		abort(404);
    	}

        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categoriesDetails = Category::where(['url'=>$url])->first();
        if($categoriesDetails->parent_id==0){
    		$subCategories = Category::where(['parent_id'=>$categoriesDetails->id])->get();
    		
    		foreach($subCategories as $subcat){
    			$cat_ids[] = $subcat->id;
            }
            $cat_ids[] = $categoriesDetails->id;
            $productsAll = Product::whereIn('category_id', $cat_ids)->where('status','1')->get();
            //$productsAll = json_decode(json_encode($productsAll));
            //echo "<pre>"; print_r($productsAll); 
    	}else{
    		$productsAll = Product::where(['category_id'=>$categoryDetails->id])->where('status','1')->get();	
    	}
        
        return view('products.listing')->with(compact('categoriesDetails','categories','productsAll'));
    }

    public function productRent($id = null){
        // Show 404 Page if Product is disabled
        $productCount = Product::where(['id'=>$id,'status'=>1])->count();
        if($productCount==0){
            abort(404);
        }

        //Get Peoduct
        $productDetails = Product::with('attributes')->where('id',$id)->first();
        //$productDetails = json_decode(json_encode($productDetails));
        //echo "<pre>"; print_r($productDetails); die;

        $relatedProducts = Product::where('id','!=',$id)->where(['category_id' => $productDetails->category_id])->get();

        $productAltImages = ProductsImage::where('product_id',$id)->get();
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();

        $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');

        return view('products.detail')->with(compact('productDetails','categories','productAltImages', 'total_stock','relatedProducts'));
    }

    public function getProductPrice(Request $request){
        $data = $request->all();
        //echo "<pre>"; print_r($data);die; 
        $proArr = explode("-",$data['id']);
        //echo $proArr[0]; echo $proArr[1]; die;
        $proArr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        echo $proArr->price; 
        echo "#";
        echo $proArr->stock; 
    }

    public function addImages(Request $request, $id = null){
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();

        $categoryDetails = Category::where(['id'=>$productDetails->category_id])->first();
        $category_name = $categoryDetails->name;
        
        if($request->isMethod('post')){
            $data = $request->all();
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                foreach($files as $file){
                    // Upload Images after Resize
                    $image = new ProductsImage;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(111,99999).'.'.$extension;
                    $large_image_path = 'img/backend_img/products/large/'.$fileName;
                    $medium_image_path = 'img/backend_img/products/medium/'.$fileName;  
                    $small_image_path = 'img/backend_img/products/small/'.$fileName;    
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600, 600)->save($medium_image_path);
                    Image::make($file)->resize(300, 300)->save($small_image_path);
                    $image->image = $fileName;  
                    $image->product_id = $data['product_id'];
                    $image->save();
                }   
            }

            return redirect('admin/add-images/'.$id)->with('flash_message_success', 'Product Images has been added successfully');

        }

        $productImages = ProductsImage::where(['product_id' => $id])->orderBy('id','DESC')->get();

        $title = "Add Images";
        return view('admin.products.add_images')->with(compact('title','productDetails','category_name','productImages'));
    }
    public function deleteProductAltImage($id=null){

        // Get Product Image
        $productImage = ProductsImage::where('id',$id)->first();

        // Get Product Image Paths
		$large_image_path = 'img/backend_img/products/large/';
		$medium_image_path = 'img/backend_img/products/medium/';
        $small_image_path = 'img/backend_img/products/small/';
        
        // Delete Large Image if not exists in Folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        // Delete Medium Image if not exists in Folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        // Delete Small Image if not exists in Folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        // Delete Image from Products Images table
        ProductsImage::where(['id'=>$id])->delete();

        return redirect()->back()->with('flash_message_success', 'Product alternate mage has been deleted successfully');
    }

    public function addToCart(Request $request){

        $data = $request->all();
        if(empty($data['user_email'])){
            $data['user_email'] = '';    
        }

        $session_id = Session::get('session_id');
        if(!isset($session_id)){
            $session_id = str_random(40);
            Session::put('session_id',$session_id);
        }

        
        $countProducts = DB::table('cart')->where(['product_id' => $data['product_id'],'product_color' => $data['product_color'],'size' => $data['size'],'session_id' => $session_id])->count();
        if($countProducts>0){
            return redirect()->back()->with('flash_message_error','Product already exist in Cart!');
        }


        $sizeIDArr = explode('-',$data['size']);
        $product_size = $sizeIDArr[1];

        $getSKU = ProductsAttribute::select('sku')->where(['product_id' => $data['product_id'], 'size' => $product_size])->first();
        
        //echo "<pre>"; print_r($data); die;
        DB::table('cart')
        ->insert(['product_id' => $data['product_id'],'product_name' => $data['product_name'],
            'product_code' => $getSKU['sku'],'product_color' => $data['product_color'],
            'price' => $data['price'],'size' => $product_size,'quantity' => $data['quantity'],'user_email' => $data['user_email'],'session_id' => $session_id]);

        return redirect('cart')->with('flash_message_success','Product has been added in Cart!');
    }

    public function cart(){
             
        $session_id = Session::get('session_id');
        $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
        foreach($userCart as $key => $product){
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }
        return view('products.cart')->with(compact('userCart'));
    }


    public function updateCartQuantity($id=null,$quantity=null){
        $getProductSKU = DB::table('cart')->select('product_code','quantity')->where('id',$id)->first();
        $getProductStock = ProductsAttribute::where('sku',$getProductSKU->product_code)->first();
        $updated_quantity = $getProductSKU->quantity+$quantity;
        if($getProductStock->stock>=$updated_quantity){
            DB::table('cart')->where('id',$id)->increment('quantity',$quantity); 
            return redirect('cart')->with('flash_message_success','Product Quantity has been updated in Cart!');   
        }else{
            return redirect('cart')->with('flash_message_error','Required Product Quantity is not available!');    
        }
    }

    public function deleteCartProduct($id=null){
        DB::table('cart')->where('id',$id)->delete();
        return redirect('cart')->with('flash_message_success','Product has been deleted in Cart!');
    }


}
