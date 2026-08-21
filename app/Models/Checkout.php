<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['cover', 'title', 'price', 'description', 'languange', 'publisher', 'writer', 'release_data', 'page_of_book'])]


class Checkout extends Model
{
    //
}
