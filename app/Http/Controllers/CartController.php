<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd(Cart::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // debugging: lihat data sebelum diproses, sama kaya console.log
        // dd($request->all());

        $request->validate([
            // memastikan pilihan harga udah di klik atau pilih dulu
            'purchase_option' => 'required',
        ]);

        if ($request->action == 'add_to_chart') {
            // menentukan isi field subscription_package_id
            $packageId = $request->purchase_option == 'none' ? null : $request->subscription_package_id;
            // updateOrCreate: dika pengguna ini udah pernah masukin buku ini (user_id dan book_id yang dijadikan acuan cari data didatabasenya), maka update pilihan pembayarannya (subscription_package_id), kalau belum ada, maka buat data baru di database
            // updaeOrCreate(['cari data berdasarkan apa saja'], ['update field apa saja'])`
            Cart::updateOrCreate([
                'user_id' => Auth::user()->id,
                'book_id' => $request->book_id,
            ], [
                'subscription_package_id' => $packageId,
            ]);
            return redirect()->route('carts')->with('success', 'Buku berhasil ditambahkan ke keranjang.');
        } else {

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
