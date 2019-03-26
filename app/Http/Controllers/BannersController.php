<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Banner;
use Image;

class BannersController extends Controller
{
    public function addBanner(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		//echo "<pre>"; print_r($data); die;	

    		$banner = new Banner;
			$banner->title = $data['title'];
			$banner->link = $data['link'];

            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }

			// Upload Image
            if($request->hasFile('image')){
            	$image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    // Upload Images after Resize
                    $extension = $image_tmp->getClientOriginalExtension();
	                $fileName = rand(111,99999).'.'.$extension;
                    $banner_path = 'img/frontend_img/banners/'.$fileName;
     				Image::make($image_tmp)->resize(2140, 640)->save($banner_path);
     				$banner->image = $fileName; 
                }
            }

            $banner->status = $status;
			$banner->save();
			return redirect()->back()->with('flash_message_success', 'Banner has been added successfully');
    	}
    	
    	return view('admin.banners.add_banners');
    }

    public function editBanner(Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }

            if(empty($data['title'])){
                $data['title'] = '';
            }

            if(empty($data['link'])){
                $data['link'] = '';
            }

            // Upload Image
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    // Upload Images after Resize
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = rand(111,99999).'.'.$extension;
                    $banner_path = 'img/frontend_img/banners/'.$fileName;
                    Image::make($image_tmp)->resize(2140, 640)->save($banner_path); 
                }
            }else if(!empty($data['current_image'])){
                $fileName = $data['current_image'];
            }else{
                $fileName = '';
            }


            Banner::where('id',$id)->update(['status'=>$status,'title'=>$data['title'],'link'=>$data['link'],'image'=>$fileName]);
            return redirect()->back()->with('flash_message_success','Banner has been edited Successfully');

        }
        $bannerDetails = Banner::where('id',$id)->first();
        return view('admin.banners.edit_banner')->with(compact('bannerDetails'));
    }

    public function viewBanners(){
        $banners = Banner::get();
        return view('admin.banners.view_banners')->with(compact('banners'));
    }

    public function deleteBanner($id = null){
        Banner::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Banner has been deleted successfully');
    }
    public function deleteBannerImage($id = null){
        
        // Get Banner Image
		$bannerImage = Banner::where('id',$id)->first();

		// Get Banner Image Paths
		$small_image_path = 'img/frontend_img/banners/';
		// Delete Large Image if not exists in Folder
        if(file_exists($small_image_path.$bannerImage->image)){
            unlink($small_image_path.$bannerImage->image);
        }

		Banner::where(['id'=>$id])->update(['image'=>'']);
		return redirect()->back()->with('flash_message_success', 'Product Image has been deleted successfully');


	}


}
