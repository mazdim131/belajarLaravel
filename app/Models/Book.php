<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// nama nama field yang akan diisi oleh pengguna/sistem, bukan default dari database
// id dan timestamps: diisi default oleh sistem database
#[Fillable(['cover', 'title', 'price', 'description', 'languange', 'publisher', 'writer', 'release_data', 'page_of_book'])]

class Book extends Model
{
    // nama tunggal tanpa e/es karena book_kategories berperan sebagai one
    // pada relasi one to many milik kategori buku
    public function BookCategory(): BelongsTo {
        return $this->belongsTo(BookCategory::class);
    }

    public function checkoutBook(): HasMany {
        return $this->hasMany(CheckoutBook::class);
    }

    public function subsctiptionPackageBook(): HasMany {
        return $this->hasMany(SubscriptionPackageBook::class);
    }
}
