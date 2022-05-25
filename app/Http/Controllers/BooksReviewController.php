<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookReview;
use App\Http\Requests\PostBookReviewRequest;
use App\Http\Resources\BookReviewResource;
use Illuminate\Http\Request;

class BooksReviewController extends Controller
{
    public function __construct()
    {
        return auth()->shouldUse('api');
    }

    public function store(int $id, PostBookReviewRequest $request)
    {
        // @TODO implement
        $book = Book::find($id);
        
        return abort_if($book === null, 404, 'Not Found');

        $validated = $request->validated();
        $bookReview = new BookReview();

        $bookReview->review = $validated['review'];
        $bookReview->comment = $validated['comment'];

        $bookReview->book()->associate($book);
        $bookReview->user()->associate(auth()->user());

        $bookReview->save();

        return new BookReviewResource($bookReview->load('user'));
    }

    public function destroy(int $bookId, int $reviewId, Request $request)
    {
        // @TODO implement
        $book = Book::find($bookId);
        
        return abort_if($book === null, 404, 'Not Found');

        $book->delete();
        $book->reviews()->detach($reviewId);

        return response()->json(null, 204);
    }
}
