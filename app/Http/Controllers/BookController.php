<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    // GET /api/books  (lista sa paginacijom i filtrima)
    public function index(Request $request)
    {
        $q = $request->query('q');                   // full-text po title/author/description
        $categoryId = $request->query('category_id');// filtriranje po kategoriji
        $perPage = (int)($request->query('per_page', 10));

        $query = Book::with('category');

        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%$q%")
                  ->orWhere('author', 'like', "%$q%")
                  ->orWhere('description', 'like', "%$q%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return response()->json($query->paginate($perPage));
    }

    // GET /api/books/{book}
    public function show(Book $book)
    {
        return response()->json($book->load('category'));
    }

    // POST /api/books
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required','string','max:255'],
            'author'      => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price'       => ['nullable','numeric','min:0'],
            'pdf_url'     => ['required','url'],
            'category_id' => ['required','exists:categories,id'],
        ]);

        $book = Book::create($data);

        return response()->json($book->load('category'), 201);
    }

    // PUT /api/books/{book}
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'       => ['sometimes','required','string','max:255'],
            'author'      => ['sometimes','required','string','max:255'],
            'description' => ['nullable','string'],
            'price'       => ['nullable','numeric','min:0'],
            'pdf_url'     => ['sometimes','required','url'],
            'category_id' => ['sometimes','required','exists:categories,id'],
        ]);

        $book->update($data);

        return response()->json($book->load('category'));
    }

    // DELETE /api/books/{book}
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent(); // 204
    }
}
