<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\PostBookRequest;
use App\Http\Resources\BookResource;
use App\Services\BookService;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct()
    {
        return auth()->shouldUse('api');
    }

    public function index(Request $request, BookService $bookService)
    {
        // @TODO implement
        $books = $bookService->list($request->query());
        
        return BookResource::collection($books);
    }

    public function store(PostBookRequest $request)
    {
        // @TODO implement
        $validated = $request->validated();
        $book = new Book();
        
        $book->isbn = $validated['isbn'];
        $book->title = $validated['title'];
        $book->description = $validated['description'];
        $book->published_year = $validated['published_year'];

        $book->save();
        $book->authors()->attach($validated['authors']);

        return new BookResource($book->load('authors')->loadCount('reviews')->loadAvg('reviews', 'review'));
    }
}
