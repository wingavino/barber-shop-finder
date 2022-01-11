<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Shop;
use Auth;

class ReviewController extends Controller
{
  public function addShopReview(Request $request, $id)
  {
    $shop = Shop::where('id', $id)->first();
    if ($shop) {
      $review = Review::where('shop_id', $shop->id)->where('user_id', Auth::user()->id)->first();
      if (!$review) {
        $review = new Review;
        $review->shop_id = $id;
        $review->user_id = Auth::user()->id;
        $review->rating = $request->rating;
        $review->review_text = $request->review_text;
        $review->save();
      }
    }
    return redirect()->route('shop.reviews', ['id' => $id]);
  }
}
