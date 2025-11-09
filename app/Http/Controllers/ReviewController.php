<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * 投稿を保存
     */
    public function store(Request $request, $storeId)
    {
        $request->validate([
            'comment' => 'required|max:500',
        ]);

        $review = new Review();
        $review->comment = $request->input('comment');
        $review->store_id = $storeId;
        $review->user_id = Auth::id();
        $review->save();

        return back()->with('success', 'レビューを投稿しました');
    }

    /**
     * 編集フォーム表示
     */
    public function edit(Review $review)
    {
        // 投稿者本人だけ編集可能
        $this->authorize('update', $review);

        return view('reviews.edit', compact('review'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $request->validate([
            'comment' => 'required|max:500',
        ]);

        $review->comment = $request->input('comment');
        $review->save();

        return redirect()->route('stores.show', $review->store_id)
                         ->with('success', 'レビューを更新しました');
    }

    /**
     * 削除処理
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $storeId = $review->store_id;
        $review->delete();

        return redirect()->route('stores.show', $storeId)
                         ->with('success', 'レビューを削除しました');
    }
}
