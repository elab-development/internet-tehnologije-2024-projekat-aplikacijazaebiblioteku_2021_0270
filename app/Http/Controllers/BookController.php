<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // vrati knjige sa kategorijom
        return response()->json(Book::with('category')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'published_year'=> 'nullable|integer',
        ]);

        $book = Book::create($data);

        return response()->json($book, 201);
    }
}
