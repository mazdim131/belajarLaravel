<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'color', 'prices'])]

class SubscriptionPackage extends Model
{
    public function SubscriptionPackageBook(): HasMany {
        return $this->hasMany(SubscriptionPackageBook::class);
    }

    public function SubscriptionPackageUser(): HasMany {
        return $this->hasMany(SubscriptionPackageUser::class);
    }
}
