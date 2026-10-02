<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// nama nama field yang akan diisi oleh pengguna/sistem, bukan default dari database
// id dan timestamps: diisi default oleh sistem database
#[Fillable(['cover', 'title', 'price', 'description', 'languange', 'publisher', 'writer', 'release_data', 'page_of_book', 'book_category_id'])]

class Book extends Model
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id', 'id');
    }

    public function checkoutBook(): HasMany {
        return $this->hasMany(CheckoutBook::class);
    }

    public function subsctiptionPackageBook(): HasMany {
        return $this->hasMany(SubscriptionPackageBook::class);
    }
}
