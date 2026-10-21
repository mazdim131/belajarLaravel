<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $subscriptionPackages = SubscriptionPackage::latest()->take(3)->get();
        $latestBooks = Book::orderBy('created_at', 'desc')->limit(10)->get();
        $freeBooks = Book::where('price', 0)->orderBy('created_at', 'desc')->limit(6)->get();

        return view('home', compact('subscriptionPackages', 'latestBooks', 'freeBooks'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $books = Book::where('title', 'like', '%'.$query.'%')
            ->orWhere('writer', 'like', '%'.$query.'%')
            ->get();

        return view('search_result', compact('books', 'query'));
    }

    public function searchCategory(Request $request)
    {
        $query = $request->input('p');
        $sort = $request->input('sort', 'latest');

        $category = null;
        if ($request->filled('category')) {
            $category = BookCategory::where('slug', $request->input('category'))->first();
        }

        $books = Book::query();

        if ($category) {
            $books = $books->where('book_category_id', $category->id);
        }

        $books = $books->where(function ($q) use ($query) {
            $q->where('title', 'like', '%'.$query.'%')
                ->orWhere('writer', 'like', '%'.$query.'%');
        });

        switch ($sort) {
            case 'price_asc':
                $books->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $books->orderBy('price', 'desc');
                break;
            default:
                $books->orderBy('release_data', 'desc');
                break;
        }

        $books = $books->paginate(12);

        return view('category_select', compact('category', 'books', 'query', 'sort'));
    }

    public function byCategory(BookCategory $category, Request $request)
    {
        $sort = $request->input('sort', 'latest');

        $books = $category->books();

        switch ($sort) {
            case 'price_asc':
                $books->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $books->orderBy('price', 'desc');
                break;
            default:
                $books->orderBy('release_data', 'desc');
                break;
        }

        $books = $books->paginate(12);

        return view('category_select', compact('category', 'books', 'sort'));
    }
}
