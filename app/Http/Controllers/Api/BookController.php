<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;


class BookController extends Controller
{

    public function store(Request $request)
    {
        $book = new Book;
        $book->nom = $request->nom;
        $book->auteur = $request->auteur;
        $book->publication_year = $request->publication_year;
        $book->isbn = $request->isbn;
        $book->save();

        return response()->json([
            "message" => "Le livre a été crée"
        ], 201);
    }

    public function index()
    {
        $books = Book::paginate(10);
        return response()->json($books, 200);
    }

    public function getBook($id)
    {
        if (Book::where('id', $id)->exists()) {
            $book = Book::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($book, 200);
        } else {
            return response()->json([
                "message" => "Livre non trouvé"
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        if (Book::where('id', $id)->exists()) {
            $book = Book::find($id);
            $book->nom = is_null($request->nom) ? $book->nom : $book->nom;
            $book->auteur = is_null($request->auteur) ? $book->auteur : $book->auteur;
            $book->publication_year = is_null($request->publication_year) ? $book->publication_year : $book->publication_year;
            $book->isbn = is_null($request->isbn) ? $book->isbn : $book->isbn;
            $book->save();

            return response()->json([
                "message" => "Le livre a été modifié avec succés"
            ], 200);
        } else {
            return response()->json([
                "message" => "Livre non trouvé"
            ], 404);
        }
    }

    public function delete($id)
    {
        if (Book::where('id', $id)->exists()) {
            $book = Book::find($id);
            $book->delete();

            return response()->json([
                "message" => "Le livre a été supprimé"
            ], 202);
        } else {
            return response()->json([
                "message" => "Livre non trouvé"
            ], 404);
        }
    }
}
