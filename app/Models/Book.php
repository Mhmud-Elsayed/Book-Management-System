<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $fillable = [
        "title_en",
        "title_ar",
        "description_en",
        "description_ar",
        "price",
        "author_id",
    ] ;
    protected $casts = [
        'price' => 'decimal:2',
    ];
    public function author()
    {
        return $this->belongsTo(Author::class);
    }


}
