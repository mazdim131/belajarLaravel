<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
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

            ->addColumn('action', function($data) {
                $deleteUrl = route('admin.subscription-packages.destroy', $data->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');
                $btnDelete = '
                    <form action="'. $deleteUrl .'"
                    method="POST" class="d-inline">

                    '. $csrf . $method.'

                    <button type="submit" class="btn btn-sm btn-danger"
                    onclick="return confirm(\'Apakah anda yakin ingin menghapus paket langganan ini?\')">
                        Hapus
                    </button>
                    </form>
                ';

                return $btnDelete;
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
    public function show(string $id)
    {
        //
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
}
