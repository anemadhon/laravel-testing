<?php

namespace App\Services;

use App\Book;

class BookService
{
    public function lists(array $queryParams)
    {
        $withSortColumn = isset($queryParams['sortColumn']) && in_array($queryParams['sortColumn'], ['title', 'published_year', 'avg_review']);
        $withSortDirection = isset($queryParams['sortDirection']) && in_array(strtolower($queryParams['sortDirection']), ['asc', 'desc']);
        $withSearchByTitle = isset($queryParams['title']) && !empty($queryParams['title']);
        $withSearchByAuthorsID = isset($queryParams['authors']) && !empty($queryParams['authors']);

        if ($withSortColumn && $withSortDirection && $withSearchByTitle) {
            if ($queryParams['sortColumn'] === 'avg_review') {
                return Book::with('authors')->withCount('reviews')->withAvg('reviews', 'review')
                    ->where('title', 'like', "%{$queryParams['title']}%")
                    ->orderBy('reviews_avg_review', $queryParams['sortDirection'])
                    ->paginate(15);
            }

            return Book::with('authors')->withCount('reviews')->withAvg('reviews', 'review')
                    ->where('title', 'like', "%{$queryParams['title']}%")
                    ->orderBy($queryParams['sortColumn'], $queryParams['sortDirection'])
                    ->paginate(15);
        }
        
        if ($withSortColumn && $withSearchByTitle) {
            if ($queryParams['sortColumn'] === 'avg_review') {
                return Book::with('authors')->withCount('reviews')->withAvg('reviews', 'review')
                    ->where('title', 'like', "%{$queryParams['title']}%")
                    ->orderBy('reviews_avg_review', $queryParams['sortDirection'])
                    ->paginate(15);
            }

            return Book::with('authors')->withCount('reviews')->withAvg('reviews', 'review')
                    ->where('title', 'like', "%{$queryParams['title']}%")
                    ->orderBy($queryParams['sortColumn'], 'asc')
                    ->paginate(15);
        }
        
        if ($withSortDirection && $withSearchByTitle) {
            return Book::with('authors')->withCount('reviews')->withAvg('reviews', 'review')
                    ->where('title', 'like', "%{$queryParams['title']}%")
                    ->orderBy('id', $queryParams['sortDirection'])
                    ->paginate(15);
        }

        if ($withSortColumn && $withSortDirection && $withSearchByAuthorsID) {
            if ($queryParams['sortColumn'] === 'avg_review') {
                return Book::with('authors')->withCount('reviews')->withAvg('reviews', 'review')
                    ->where('title', 'like', "%{$queryParams['title']}%")
                    ->orderBy('reviews_avg_review', $queryParams['sortDirection'])
                    ->paginate(15);
            }

            return Book::with('authors', function($query) {
                $query->whereIn('id', explode(',', $queryParams['authors']));
            })->withCount('reviews')->withAvg('reviews', 'review')
                ->orderBy($queryParams['sortColumn'], $queryParams['sortDirection'])
                ->paginate(15);
        }
        
        if ($withSortColumn && $withSearchByAuthorsID) {
            if ($queryParams['sortColumn'] === 'avg_review') {
                return Book::with('authors')->withCount('reviews')->withAvg('reviews', 'review')
                    ->where('title', 'like', "%{$queryParams['title']}%")
                    ->orderBy('reviews_avg_review', $queryParams['sortDirection'])
                    ->paginate(15);
            }

            return Book::with('authors', function($query) {
                $query->whereIn('id', explode(',', $queryParams['authors']));
            })->withCount('reviews')->withAvg('reviews', 'review')
                ->orderBy($queryParams['sortColumn'], 'asc')
                ->paginate(15);
        }
        
        if ($withSortDirection && $withSearchByAuthorsID) {
            return Book::with('authors', function($query) {
                $query->whereIn('id', explode(',', $queryParams['authors']));
            })->withCount('reviews')->withAvg('reviews', 'review')
                ->orderBy('id', $queryParams['sortDirection'])
                ->paginate(15);
        }

        if ($withSortColumn) {
            if ($queryParams['sortColumn'] === 'avg_review') {
                return Book::with('authors')->withCount('reviews')->withAvg('reviews', 'review')
                    ->where('title', 'like', "%{$queryParams['title']}%")
                    ->orderBy('reviews_avg_review', $queryParams['sortDirection'])
                    ->paginate(15);
            }

            return Book::with('authors')->withCount('reviews')->withAvg('reviews', 'review')
                    ->orderBy($queryParams['sortColumn'], 'asc')
                    ->paginate(15);
        }
        
        if ($withSortDirection) {
            return Book::with('authors')->withCount('reviews')->withAvg('reviews', 'review')
                    ->orderBy('id', $queryParams['sortDirection'])
                    ->paginate(15);
        }
        
        if ($withSearchByTitle) {
            return Book::with('authors')->withCount('reviews')->withAvg('reviews', 'review')
                    ->where('title', 'like', "%{$queryParams['title']}%")
                    ->paginate(15);
        }
        
        if ($withSearchByAuthorsID) {
            return Book::with('authors', function($query) {
                $query->whereIn('id', explode(',', $queryParams['authors']));
            })->withCount('reviews')->withAvg('reviews', 'review')
                ->paginate(15);
        }
    }
}
