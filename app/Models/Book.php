<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title','author','description','price','pdf_url','category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
