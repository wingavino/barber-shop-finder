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
            $fileModal->type = 'image';

            $fileModal->save();
          }
        }

       return redirect()->route('shopowner.shop.images');
    }
  }

  public function uploadLogo(Request $request)
  {
    $request->validate([
      'logoFile' => 'required',
      'logoFile.*' => 'mimes:jpeg,jpg,png|max:10240'
    ]);

    if($request->hasfile('logoFile')) {
      $image = $request->file('logoFile');
      $name = 'logo';
      $extension = $image->getClientOriginalExtension();
      $name = 'logo/'.$name.'.'.$extension;
      $image->move(public_path().'/img/'.Auth::user()->shop->id.'/logo/', $name);
      $logoData = $name;

      $file = Image::where('shop_id', Auth::user()->shop->id)->where('path', $logoData)->first();
      if (!$file) {
        $fileModal = new Image();
        $fileModal->shop_id = Auth::user()->shop->id;
        $fileModal->path = $logoData;
        $fileModal->type = 'logo';

        $fileModal->save();
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

public function uploadUserID(Request $request)
{
  $request->validate([
    'imgFile' => 'required',
    'imgFile.*' => 'mimes:jpeg,jpg,png|max:10240'
  ]);

  if($request->hasfile('imgFile')) {
    $image = $request->file('imgFile');
    $name = 'id';
    $extension = $image->getClientOriginalExtension();
    $name = 'id/'.$name.'.'.$extension;
    $image->move(public_path().'/img/'.Auth::user()->id.'/id/', $name);
    $imgData = $name;

    $file = Image::where('user_id', Auth::user()->id)->where('path', $imgData)->first();
    if (!$file) {
      $fileModal = new Image();
      $fileModal->user_id = Auth::user()->id;
      $fileModal->path = $imgData;
      $fileModal->type = 'id';

      $fileModal->save();
    }

     return redirect()->route('home');
  }
}
