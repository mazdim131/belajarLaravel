<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Checkout;
use App\Models\CheckoutBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Book::query()->with('category');

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('coverImg', function ($row) {
                    // asset: mengambil file yang ada di folder public
                    return '<img src="'.asset($row->cover).'" width="100" class="d-block mx-auto" />';
                })
                ->addColumn('price', function ($row) {
                    return 'Rp '.number_format($row->price, 0, ',', '.');
                })
                ->editColumn('book_category_id', function ($row) {
                    return $row->category?->name ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="'.route('admin.books.edit', $row->id).'" class="btn btn-primary me-2">Edit</a>';
                    $btnDelete = '<form method="POST" action="'.route('admin.books.destroy', $row->id).'">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-danger">Delete</button></form>';
                    $btnDetail = '<button type="button" class="btn btn-warning btn-detail"
                    data-cover="'.asset($row->cover).'"
                    data-title="'.$row->title.'"
                    data-category="'.$row->category->name.'"
                    data-price="'.$row->price.'"
                    data-writer="'.$row->writer.'"
                    data-publisher="'.$row->publisher.'"
                    data-language="'.$row->languange.'"
                    data-page-of-book="'.$row->page_of_book.'"
                    data-release-date="'.date('d M Y', strtotime($row->release_data)).'"
                    data-description="'.$row->description.'">Detail</button>';

                    return $btnEdit.$btnDelete.$btnDetail;
                })
                ->rawColumns(['action', 'coverImg'])
                ->toJson();
        }

        return view('admin.books.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bookCategories = BookCategory::all();

        return view('admin.books.create', compact('bookCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cover' => ['required', 'mimes:jpg,jpeg,png,svg,webp'],
            'title' => ['required'],
            'writer' => ['required'],
            'publisher' => ['required'],
            'price' => ['required', 'numeric'],
            'languange' => ['required'],
            'description' => ['nullable'],
            'book_category_id' => ['required', 'exists:book_categories,id'],
            'page_of_book' => ['required', 'numeric'],
            'release_data' => ['required', 'date'],
        ]);

        if ($request->file('cover')) {
            $cover = $request->file('cover');
            $namaFile = time().'.'.$cover->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('covers', $cover, $namaFile);
            $validatedData['cover'] = Storage::url('covers/'.$namaFile);
        }

        Book::create($validatedData);

        return redirect()->route('admin.books.index')->with('success', 'Berhasil membuat data buku baru');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Book::where('id', $id)->with('subscriptionPackageBooks')->first();
        return view('user.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $bookCategories = BookCategory::all();

        return view('admin.books.edit', compact('book', 'bookCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validatedData = $request->validate([
            'cover' => ['nullable', 'mimes:jpg,jpeg,png,svg,webp'],
            'title' => ['required'],
            'writer' => ['required'],
            'publisher' => ['required'],
            'price' => ['required', 'numeric'],
            'languange' => ['required'],
            'description' => ['nullable'],
            'book_category_id' => ['required', 'exists:book_categories,id'],
            'page_of_book' => ['required', 'numeric'],
            'release_data' => ['required', 'date'],
        ]);

        if ($request->file('cover')) {
            if ($book->cover) {
                $oldCover = str_replace(Storage::url(''), '', $book->cover);
                Storage::disk('public')->delete($oldCover);
            }
            $cover = $request->file('cover');
            $namaFile = time().'.'.$cover->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('covers', $cover, $namaFile);
            $validatedData['cover'] = Storage::url('covers/'.$namaFile);
        }

        $book->update($validatedData);

        return redirect()->route('admin.books.index')->with('success', 'Berhasil memperbarui data buku');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->cover) {
            $oldCover = str_replace(Storage::url(''), '', $book->cover);
            Storage::disk('public')->delete($oldCover);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Berhasil menghapus data buku');
    }

    public function export()
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }

    public function checkoutPage($id)
    {
        $book = Book::findOrFail($id);

        return view('checkoutBooks', compact('book'));
    }

    public function checkout(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $checkout = Checkout::create([
            'user_id' => Auth::id(),
            'payment_method' => 'QRIS',
            'total_book' => 1,
            'total_book_price' => $book->price,
            'total_price' => $book->price,
            'status' => 'Pending',
        ]);

        CheckoutBook::create([
            'checkout_id' => $checkout->id,
            'book_id' => $book->id,
            'total_book' => 1,
        ]);

        return redirect()->route('home')->with('success', 'Checkout buku berhasil!');
    }
}
