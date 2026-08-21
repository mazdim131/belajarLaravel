<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

// nama nama field yang akan diisi oleh pengguna/sistem, bukan default dari database
// id dan timestamps: diisi default oleh sistem database
#[Fillable(['cover', 'title', 'price', 'description', 'languange', 'publisher', 'writer', 'release_data', 'page_of_book'])]

class Book extends Model
{
    //
}
