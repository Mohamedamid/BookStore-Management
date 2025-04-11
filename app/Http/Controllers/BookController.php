<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        $livres = Book::all();
        return view('livre', compact('livres'));
    }
    // Store a new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'niveau_academique' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $book = Book::create([
            'title' => $request->title,
            'niveau_academique' => $request->niveau_academique,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return redirect()->route('book.index')->with('success', 'Book created successfully!');
    }

    // Update an existing book
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'niveau_academique' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $book->update([
            'title' => $request->title,
            'niveau_academique' => $request->niveau_academique,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return redirect()->route('book.index')->with('success', 'Book updated successfully!');
    }

    // Delete a book
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('book.index')->with('success', 'Book deleted successfully!');
    }
}
