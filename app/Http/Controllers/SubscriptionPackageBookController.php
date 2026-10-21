<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionPackageBook;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionPackageBookController extends Controller
{
    public function show($id, Request $request)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);

        // id buku yang sudah tertaut ke paket ini, dipakai untuk menandai checkbox
        $selectedBookIds = $subscriptionPackage->SubscriptionPackageBook()
            ->pluck('book_id')
            ->map(fn ($bookId) => (int) $bookId)
            ->all();

        // semua data buku untuk dipilih mana yang akan di tautkan ke paket langganan
        // ajax() dipakai karena request dari DataTables, expectsJson() untuk request json biasa
        if ($request->ajax() || $request->expectsJson()) {
            $model = Book::query()->with('category');

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('coverImg', function ($row) {
                    // asset: mengambil file yang ada di folder public
                    return '<img src="'.asset($row->cover).'" width="100" class="d-block mx-auto" />';
                })
                ->editColumn('price', function ($row) {
                    return 'Rp. '.number_format($row->price, 0, ',', '.');
                })
                ->editColumn('title', fn ($row) => e($row->title))
                ->editColumn('writer', fn ($row) => e($row->writer))
                ->editColumn('book_category_id', function ($row) {
                    // category diambil dari func relasi yg ada di modek book
                    return e($row->category?->name ?? '-');
                })
                ->addColumn('is_selected', function ($row) use ($selectedBookIds) {
                    // 1 kalau buku ini sudah tertaut ke paket, 0 kalau belum
                    return in_array((int) $row->id, $selectedBookIds) ? 1 : 0;
                })
                ->rawColumns(['coverImg'])
                ->toJson();
        }

        return view('admin.subscription-packages.books', compact('subscriptionPackage', 'selectedBookIds'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subscription_package_id' => ['required', 'exists:subscription_packages,id'],
            // book_id dikirim sebagai array karena user bisa mencentang lebih dari satu buku
            'book_id' => ['required', 'array', 'min:1'],
            'book_id.*' => ['exists:books,id'],
            'expired_date' => ['required', 'date'],
        ]);

        $subscriptionPackage = SubscriptionPackage::findOrFail($validatedData['subscription_package_id']);

        // hapus relasi lama dulu, lalu simpan ulang sesuai pilihan checkbox terbaru
        // supaya data di database selalu sama dengan yang diceklis di tabel
        $subscriptionPackage->SubscriptionPackageBook()->delete();

        foreach ($validatedData['book_id'] as $bookId) {
            SubscriptionPackageBook::create([
                'book_id' => $bookId,
                'subscription_package_id' => $subscriptionPackage->id,
                'expired_date' => $validatedData['expired_date'],
            ]);
        }

        return redirect()
            ->route('admin.subscription-packages.books', $subscriptionPackage->id)
            ->with('success', 'Buku berhasil ditambahkan ke paket langganan.');
    }
}
