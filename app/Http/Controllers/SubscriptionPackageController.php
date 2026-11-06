<?php

namespace App\Http\Controllers;

use App\Exports\SubscriptionPackagesExport;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionPackageUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = SubscriptionPackage::query();

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('action', function (SubscriptionPackage $data) {
                    $booksUrl = route('admin.subscription-packages.books', $data->id);
                    $editUrl = route('admin.subscription-packages.edit', $data->id);
                    $deleteUrl = route('admin.subscription-packages.destroy', $data->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    $btnBuku = '<a href="'.$booksUrl.'" class="btn btn-sm btn-info">Buku</a>';
                    $btnDelete = '<form action="'.$deleteUrl.'" method="POST" class="d-inline">'.$csrf.$method.'<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah anda yakin ingin menghapus paket langganan ini?\')">Hapus</button></form>';
                    $btnEdit = '<a href="'.$editUrl.'" class="btn btn-warning btn-sm">Edit</a>';

                    return $btnBuku.$btnDelete.$btnEdit;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.subscription-packages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscription-packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'description' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:20'],
            'prices' => ['required', 'numeric'],
        ]);

        SubscriptionPackage::create($validateData);

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Pilihan paket langganan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);

        $search = $request->input('search');

        $books = $subscriptionPackage->SubscriptionPackageBook()
            ->with('Book')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('Book', function ($q) use ($search) {
                    $q->where('title', 'like', '%'.$search.'%');
                });
            })
            ->paginate(12);

        return view('user.subscription-packages.show', compact('subscriptionPackage', 'books', 'search'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);

        return view('admin.subscription-packages.edit', compact('subscriptionPackage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);

        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'description' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:20'],
            'prices' => ['required', 'numeric'],
        ]);

        $subscriptionPackage->update($validateData);

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Paket langganan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);

        $subscriptionPackage->delete();

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Paket langganan berhasil dihapus!');
    }

    public function checkoutPage($id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);

        return view('user.subscription-packages.checkout', compact('subscriptionPackage'));
    }

    public function checkout(Request $request, $id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);

        SubscriptionPackageUser::create([
            'subscription_package_id' => $subscriptionPackage->id,
            'user_id' => Auth::id(), // ambil id orang yang login, mendeteksi siapa user yang belinya
            // 30 hari dari sekarang, format tahun-bulan-tanggal
            'expired_date' => now()->addMonth(),
        ]);

        return redirect()->route('home')->with('success', 'Checkout berhasil!');
    }

    public function export()
    {
        return Excel::download(new SubscriptionPackagesExport, 'subscription_packages.xlsx');
    }
}
