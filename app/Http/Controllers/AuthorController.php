<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequests\StoreAuthorRequest;
use App\Http\Requests\AuthorRequests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        try {
            $authors = Author::all();

            return $this->apiResponseSuccess('Authors retrieved successfully!', AuthorResource::collection($authors), 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function store(StoreAuthorRequest $request)
    {
        try {
            $validated_request = $request->safe();

            $author = Author::create($validated_request->toArray());

            return $this->apiResponseSuccess('Author created successfully!', new AuthorResource($author), 201);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
    
    public function show(Author $author)
    {
        return $this->apiResponseSuccess('Author retrieved successfully!', new AuthorResource($author), 200);
    }

    public function update(Author $author, UpdateAuthorRequest $request)
    {
        try {
            $validated_request = $request->safe();

            $author->update($validated_request->toArray());

            return $this->apiResponseSuccess('Author updated successfully!', new AuthorResource($author), 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function destroy(Author $author)
    {
        try {
            $author->delete();

            return $this->apiResponseSuccess('Author removed!', null, 204);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
}
