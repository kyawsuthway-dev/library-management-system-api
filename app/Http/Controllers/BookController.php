<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequests\SearchBookRequest;
use App\Http\Requests\BookRequests\StoreBookRequest;
use App\Http\Requests\BookRequests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(SearchBookRequest $request)
    {
        try {
            $validated_request = $request->safe();

            $books = Book::with(['publisher:id,name,address,phone', 'category:id,name', 'authors:id,name'])->filter(
                $validated_request->toArray()
            )->get();

            return $this->apiResponseSuccess('Books retrieved successfully!', BookResource::collection($books), 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function store(StoreBookRequest $request)
    {
        try {
            $validated_request = $request->safe()->only([
                'publisher_id',
                'category_id',
                'title',
                'pages',
                'quantity',
            ]);

            $book = Book::create($validated_request);

            $book->authors()->attach($request->authors);

            return $this->apiResponseSuccess('Book created successfully!', new BookResource($book), 201);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
    
    public function show(Book $book)
    {
        return $this->apiResponseSuccess('Book retrieved successfully!', new BookResource($book), 200);
    }

    public function update(Book $book, UpdateBookRequest $request)
    {
        try {
            $validated_request = $request->safe()->only([
                'publisher_id',
                'category_id',
                'title',
                'pages',
                'quantity',
            ]);

            $book->update($validated_request);

            if ($request->has('authors')) {
                $book->authors()->sync($request->authors);
            }

            return $this->apiResponseSuccess('Book updated successfully!', new BookResource($book), 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function destroy(Book $book)
    {
        try {
            $book->delete();

            return $this->apiResponseSuccess('Book removed!', null, 204);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
}
