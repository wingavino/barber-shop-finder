<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Shop;
use App\Models\PendingRequest;
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

  public function reportReview(Request $request, $id, $review_id, $request_type, $user_id)
  {
    $shop = Shop::where('id', $id)->first();
    if ($shop) {
      $review = Review::where('shop_id', $shop->id)->where('id', $review_id)->first();
      if ($review) {
        $pending_request = new PendingRequest;
        $pending_request->user_id = $user_id;
        $pending_request->request_type = $request_type;
        $pending_request->report_reason = $request->report_reason;
        $pending_request->review_id = $review_id;
        $pending_request->shop_id = $shop->id;
        $pending_request->save();
      }
    }
    return redirect()->route('shop.reviews', ['id' => $id]);
  }
  
  public function deleteReview(Request $request, $id)
  {
    $review = Review::where('id', $id)->first();
    if ($review) {
      $reports = PendingRequest::where('request_type', 'report-review')->where('review_id', $review->id)->get();
      if ($reports) {
        foreach ($reports as $report => $value) {
          $value->delete();
        }
      }
      $review->delete();
    }
    return redirect()->route('admin.pending-requests');
  }
}
