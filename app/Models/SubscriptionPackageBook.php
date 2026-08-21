<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['book_id', 'subscription_package_id', 'expired_date'])]

class SubscriptionPackageBook extends Model
{
    //
}
