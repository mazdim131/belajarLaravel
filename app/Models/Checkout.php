<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['cover', 'title', 'price', 'description', 'languange', 'publisher', 'writer', 'release_data', 'page_of_book'])]


class Checkout extends Model
{
    public function checkoutBook(): HasMany {
        return $this->hasMany(checkoutBook::class);
    }

    public function User(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
