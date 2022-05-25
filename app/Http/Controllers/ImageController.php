<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Shop;
use Auth;
use File;

class ImageController extends Controller
{
  public function showUploadImage($id)
  {
    $shop = Shop::where('id', $id)->first();

    if (Auth::user()->type == 'admin') {
      return view('admin/shop-images-upload', ['shop' => $shop]);
    }else {
      return view('shopowner/shop-images-upload', ['shop' => Auth::user()->shop]);
    }
  }

  public function showUploadID()
  {
    return view('shopowner/image-id-upload');
  }

  public function showUploadShopDocument()
  {
    return view('shopowner/image-shop-document-upload');
  }

  public function uploadImage($id, Request $request)
  {
    $request->validate([
      'imageFile' => 'required',
      'imageFile.*' => 'mimes:jpeg,jpg,png|max:10240'
    ]);

    if($request->hasfile('imageFile')) {
        foreach($request->file('imageFile') as $image)
        {
            $name = $image->getClientOriginalName();
            $image->move(public_path().'/img/shop/'.$id, $name);
            $imgData[] = $name;
        }

        foreach ($imgData as $img) {
          $img = "shop/". $id . '/' . $img;
          $file = Image::where('shop_id', $id)->where('path', $img)->first();
          if (!$file) {
            $fileModal = new Image();
            $fileModal->shop_id = $id;
            $fileModal->path = $img;
            $fileModal->type = 'images';

            $fileModal->save();
          }
        }

       return redirect()->route('admin.shop.images', ['id' => $id]);
    }
  }

  public function uploadLogo($id, Request $request)
  {
    $request->validate([
      'logoFile' => 'required',
      'logoFile.*' => 'mimes:jpeg,jpg,png|max:10240'
    ]);

    if($request->hasfile('logoFile')) {
      $image = $request->file('logoFile');
      $name = 'logo';
      $extension = $image->getClientOriginalExtension();
      $name = 'shop/' .$id. '/logo/'.$name.'.'.$extension;
      $logoData = $name;

      $file = Image::where('shop_id', $id)->where('type', 'logo')->first();
      if ($file) {
        $file->path = $logoData;
        $file->save();
      }else {
        $fileModal = new Image();
        $fileModal->shop_id = $id;
        $fileModal->path = $logoData;
        $fileModal->type = 'logo';

        $fileModal->save();
      }
      $image->move(public_path().'/img/shop/' .$id. '/logo/', $name);

       return redirect()->route('admin.shop.images', ['id' => $id]);
    }
  }

  public function deleteImage(Request $request, $id, $image_id)
  {
    $shop = Shop::where('id', $id)->first();
    $image = Image::where('shop_id', $shop->id)->where('id', $image_id)->first();
    $file = public_path('img/'.$image->path);
    if(File::exists($file)){
        File::delete($file);
        if ($image) {
          $image->delete();
          return redirect()->route('admin.shop.images', ['id' => $shop->id]);
        }
    }

  }

  public function uploadID(Request $request)
  {
    $request->validate([
      'imgFile' => 'required',
      'imgFile.*' => 'mimes:jpeg,jpg,png|max:20480'
    ]);

    if($request->hasfile('imgFile')) {
      $image = $request->file('imgFile');
      $name = 'id';
      $extension = $image->getClientOriginalExtension();
      $name = 'id/'.$name.'.'.$extension;
      $imgData = $name;
      $file = Image::where('user_id', Auth::user()->id)->where('type', 'id')->first();
      if ($file) {
        $file->path = $imgData;
        $file->save();
      }else {
        $fileModal = new Image();
        $fileModal->user_id = Auth::user()->id;
        $fileModal->path = $imgData;
        $fileModal->type = 'id';

        $fileModal->save();
      }

      $image->move(public_path().'/img/'.Auth::user()->id.'/id/', $name);

      return redirect()->route('shopowner.img.id');
    }
  }

  public function uploadShopDocument(Request $request)
  {
    $request->validate([
      'imgFile' => 'required',
      'imgFile.*' => 'mimes:jpeg,jpg,png|max:20480'
    ]);

    if($request->hasfile('imgFile')) {
      $image = $request->file('imgFile');
      $name = 'doc';
      $extension = $image->getClientOriginalExtension();
      $name = 'shop/doc/'.$name.'.'.$extension;
      $imgData = $name;
      $file = Image::where('shop_id', Auth::user()->shop->id)->where('type', 'doc')->first();
      if ($file) {
        $file->path = $imgData;
        $file->save();
      }else {
        $fileModal = new Image();
        $fileModal->shop_id = Auth::user()->shop->id;
        $fileModal->path = $imgData;
        $fileModal->type = 'doc';

        $fileModal->save();
      }

      $image->move(public_path().'/img/'.Auth::user()->id.'/shop/doc/', $name);

      return redirect()->route('shopowner.img.shop.doc');
    }
  }
}
