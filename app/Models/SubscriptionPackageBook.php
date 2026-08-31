<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['book_id', 'subscription_package_id', 'expired_date'])]

class SubscriptionPackageBook extends Model
{
    public function SubscriptionPackage(): BelongsTo {
        return $this->belongsTo(SubscriptionPackage::class);
    }

    public function Book(): BelongsTo {
        return $this->belongsTo(Book::class);
    }
}
