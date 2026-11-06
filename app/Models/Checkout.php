<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CheckoutBook;
use App\Models\User;

#[Fillable(['user_id', 'payment_method', 'total_book', 'total_book_price', 'total_price', 'status'])]


class Checkout extends Model
{
    public function checkoutBook(): HasMany {
        return $this->hasMany(CheckoutBook::class);
    }

    public function User(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}