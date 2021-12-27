<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Auth;
use File;

class ImageController extends Controller
{
  public function showUploadImage()
  {
    return view('shopowner/shop-images-upload');
  }

  public function uploadImage(Request $request)
  {
    $request->validate([
      'imageFile' => 'required',
      'imageFile.*' => 'mimes:jpeg,jpg,png|max:10240'
    ]);

    if($request->hasfile('imageFile')) {
        foreach($request->file('imageFile') as $image)
        {
            $name = $image->getClientOriginalName();
            $image->move(public_path().'/img/'.Auth::user()->shop->id.'/', $name);
            $imgData[] = $name;
        }

        foreach ($imgData as $img) {
          $file = Image::where('shop_id', Auth::user()->shop->id)->where('path', $img)->first();
          if (!$file) {
            $fileModal = new Image();
            $fileModal->shop_id = Auth::user()->shop->id;
            $fileModal->path = $img;

            $fileModal->save();
          }
        }

       return redirect()->route('shopowner.shop.images');
    }
  }

  public function deleteImage(Request $request, $id)
  {
    $image = Image::where('shop_id', Auth::user()->shop->id)->where('id', $id)->first();
    $file = public_path('img/'.Auth::user()->shop->id.'/'.$image->path);
    if(File::exists($file)){
        File::delete($file);
        if ($image) {
          $image->delete();
          return redirect()->route('shopowner.shop.images');
        }
    }

  }
}
