<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['user_id', 'subscription_package_id', 'expired_date'])]

class SubscriptionPackageUser extends Model
{
    //
}
