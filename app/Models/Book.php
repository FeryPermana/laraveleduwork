<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function publisher()
    {
        $this->belongsTo(Publisher::class);
    }

    public function author()
    {
        $this->belongsTo(Author::class);
    }

    public function catalog()
    {
        $this->belongsTo(Catalog::class);
    }
}
