<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // all : mengambil semua data dari model BookCategory dan menyimpannya ke dalam variable $bookcategorys
        if ($request->ajax()) {
            // $request->ajax() jika ada permintaan dari ajax javascript, permintaan proses datatables dipanggil melalui ajax javascript di bladenya
            $model = BookCategory::query();

            return DataTables::eloquent($model)
            // memberikan nomor urut data 1-2-dst
                ->addIndexColumn()
            // addColumn dipaka untuk styling element

            // menambahkan/mengubah data selain yang ada di database : mengubah data atau untuk btn aksi
                ->addColumn('action', function ($data) {
                    $editUrl = route('admin.book-categories.edit', $data->id);
                    $deleteUrl = route('admin.book-categories.destroy', $data->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    $btnEdit = '<a href="'. $editUrl .'" class="btn btn-sm btn-warning">Edit</a>';
                    $btnDelete = '
                                <form action="'. $deleteUrl .'"
                                    method="POST" class="d-inline">
                                    '. $csrf . $method .'
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm(\'Apakah anda yakin ingin menghapus paket langganan ini? \')">
                                        Hapus
                                    </button>
                                </form>

                    ';

                    return $btnEdit . $btnDelete;
                })

                // menyimpan dari addcolumn yang ada html didalemnya
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.book-categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.book-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        BookCategory::create($validateData);

        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil ditambahkan.');
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
        $bookCategory = BookCategory::findOrFail($id);

        return view('admin.book-categories.edit', compact('bookCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bookCategory = BookCategory::findOrFail($id);

        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $bookCategory->update($validateData);

        // update digunakan pada model untuk mengubah data, namun penggunaannya harus setelah proses pencarian data yang akan diubahnya
        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku telah berhasil di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bookCategory = BookCategory::findOrFail($id);

        $bookCategory->delete();

        // delete digunakan pada model untuk menghapus data, namun penggunaannya harus setelah proses pencarian data yang akan diubahnya
        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku telah berhasil di hapus');
    }
}
