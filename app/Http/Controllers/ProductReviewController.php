<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductReviewController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {;
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        $productReview = new ProductReview([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'rating' => $request->rating,
            'review' => $request->review,
            'approved' => false,
        ]);

        $productReview->save();

        return redirect()->route('product.detail',$request->product_id)->with('review_status', 'success')
            ->with('message', 'Değelendirmeniz için teşekkürler. Onaylandıktan sonra yayınlanacaktır.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $productReview = ProductReview::find($id);
        $productReview->delete();
        return redirect()->back()->with('status', 'info')
            ->with('message', 'Değerlendirme silindi.');
    }

    public function approve(Request $request,$id)
    {
        $productReview = ProductReview::find($id);
        $productReview->approve();
        return redirect()->route('admin.review.list')->with('status', 'info')
            ->with('message', 'Değerlendirme onaylandı.');
    }

    public function show_waiting_reviews()
    {
        return view('admin.review.waiting');
    }

    public function show_all()
    {
        return view('admin.review.index');
    }

}
