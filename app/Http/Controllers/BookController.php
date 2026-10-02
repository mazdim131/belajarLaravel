<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use OpenSpout\Common\Entity\Row;
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
            -> addIndexColumn()
            -> addColumn('coverImg', function($row) {
                // asset: mengambil file yang ada di folder public
                return '<img src="' . asset($row->cover) . '" width="100" class="d-block mx-auto" />';
            })
            ->addColumn('price', function($row) {
                return 'Rp ' . number_format($row->price, 0, ',', '.');
            })
            ->editColumn('book_category_id', function($row) {
                return $row->category?->name ?? '-';
            })
            ->addColumn('action', function($row) {
                $btnEdit = '<a href="'. route('admin.books.edit', $row->id) .'" class="btn btn-primary me-2">Edit</a>';
                $btnDelete = '<form method="POST" action="' . route('admin.books.destroy', $row->id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger">Delete</button></form>';
                $btnDetail = '<button type="button" class="btn btn-warning btn-detail"
                    data-cover="'. asset($row->cover) .'"
                    data-title="'. $row->title .'"
                    data-category="'. $row->category->name .'"
                    data-price="'. $row->price .'"
                    data-writer="'. $row->writer .'"
                    data-publisher="'. $row->publisher .'"
                    data-language="'. $row->languange .'"
                    data-page-of-book="'. $row->page_of_book .'"
                    data-release-date="'. date('d M Y', strtotime($row->release_date)) .'"
                    data-description="'. $row->description .'"
                >Detail</button>';

                return $btnEdit . $btnDelete . $btnDetail;
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
            $namaFile = time() . "." . $cover->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('covers', $cover, $namaFile);
            $validatedData['cover'] = Storage::url('covers/' . $namaFile);
        }

        Book::create($validatedData);
        return redirect()->route('admin.books.index')->with('success', 'Berhasil membuat data buku baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
            'release_date' => ['required', 'date']
        ]);

        if ($request->file('cover')) {
            if ($book->cover) {
                $oldCover = str_replace(Storage::url(''), '', $book->cover);
                Storage::disk('public')->delete($oldCover);
            }
            $cover = $request->file('cover');
            $namaFile = time() . "." . $cover->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('covers', $cover, $namaFile);
            $validatedData['cover'] = Storage::url('covers/' . $namaFile);
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
}
