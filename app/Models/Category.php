<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Jedna kategorija ima više knjiga
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
