<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionPackageBook;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionPackageBookController extends Controller
{
    public function show($subscriptionPackageId, Request $request)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($subscriptionPackageId);

        // Dapatkan ID buku yang sudah tertaut ke paket ini
        $selectedBookIds = $subscriptionPackage->SubscriptionPackageBook()
            ->pluck('book_id')
            ->map(fn ($bookId) => (int) $bookId)
            ->all();

        if ($request->ajax()) {
            $model = Book::query()->with('category');

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('coverImg', function ($row) {
                    return '<img src=" '.asset($row->cover).'" width="100" class="d-block mx-auto" />';
                })
                ->editColumn('price', function ($row) {
                    return 'Rp '.number_format($row->price, 0, ',', '.');
                })
                ->editColumn('book_category_id', function ($row) {
                    return $row->category->name ?? '-';
                })
                ->addColumn('checkAdded', function ($row) use ($subscriptionPackage) {
                    // pluck : ambil semua dari book_id dari subscriptionPackageBook, lalu ubah menjadi array
                    $subscriptionPackageBook = $subscriptionPackage->subscriptionPackageBook()
                        ->pluck('book_id')
                        ->toArray();

                    // cek apakah book_id dari row ada dalam array subscriptionPackageBook, jika ada maka buku sudah tertaur dengan paket langganan ini (checkbox dihilangkan)
                    return in_array($row->id, $subscriptionPackageBook) ? 'Ya' : 'Tidak';
                })
                ->addColumn('is_selected', function ($row) use ($selectedBookIds) {
                    return in_array((int) $row->id, $selectedBookIds) ? 1 : 0;
                })
                ->rawColumns(['coverImg'])
                ->toJson();
        }

        return view('admin.subscription-packages.books', compact('subscriptionPackage', 'selectedBookIds'));
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'subscription_package_id' => ['required', 'exists:subscription_packages,id'],
    //         'book_id' => ['required', 'array', 'min:1'],
    //         'book_id.*' => ['exists:books,id'],
    //         'expired_date' => ['required', 'date'],
    //     ]);

    //     $packageId = $validated['subscription_package_id'];

    //     // Hapus semua tautan buku yang ada untuk paket ini, lalu masukkan yang baru
    //     SubscriptionPackageBook::where('subscription_package_id', $packageId)->delete();

    //     foreach ($validated['book_id'] as $bookId) {
    //         SubscriptionPackageBook::create([
    //             'subscription_package_id' => $packageId,
    //             'book_id' => $bookId,
    //             'expired_date' => $validated['expired_date'],
    //         ]);
    //     }

    //     return redirect()->route('admin.subscription-packages.books', $packageId)
    //         ->with('success', 'Buku berhasil disimpan ke paket langganan!');
    // }

    public function store(Request $request, $id)
    {
        $bookIds = $request->input('book_ids', []);

        if (empty($bookIds)) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu buku.');
        }

        foreach ($bookIds as $bookId) {
            SubscriptionPackageBook::create([
                'subscription_package_id' => $id,
                'book_id' => $bookId,
                'expired_date' => now()->addDays(30),
            ]);
        }

        return redirect()->back()->with('success', 'Buku berhasil di tambahkan ke paket langganan');
    }
}
