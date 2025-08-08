<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // GET /api/books
    public function index()
    {
        return response()->json(
            Book::with('category')->paginate(10)
        );
    }

    // POST /api/books
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric',
            'pdf_url'     => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book = Book::create($data);

        return response()->json($book->load('category'), 201);
    }

    // GET /api/books/{book}
    public function show(Book $book)
    {
        return response()->json($book->load('category'));
    }

    // PUT/PATCH /api/books/{book}
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'author'      => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric',
            'pdf_url'     => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $book->update($data);

        return response()->json($book->load('category'));
    }

    // DELETE /api/books/{book}
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Deleted'], 204);
    }
}
