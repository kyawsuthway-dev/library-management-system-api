<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowRequests\ReturnBorrowedBookRequest;
use App\Http\Requests\BorrowRequests\StoreBorrowRequest;
use App\Http\Resources\BorrowResource;
use App\Http\Resources\UserResource;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function index()
    {
        try {
            $borrows = Borrow::where('returned_at', null)->get();

            return $this->apiResponseSuccess('Borrowed books retrievid success!', BorrowResource::collection($borrows), 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function store(StoreBorrowRequest $request)
    {
        try {
            $user = User::find($request->user_id);

            $user->borrows()->attach($request->books, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $books = Book::whereIn('id', $request->books)->update(['borrowed' => true]);

            return $this->apiResponseSuccess('Borrowing book success!', new UserResource($user), 201);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
    
    public function returnBook(ReturnBorrowedBookRequest $request)
    {
        try {
            $borrows = Borrow::where('user_id', $request->user_id)
                        ->where('returned_at', null)
                        ->whereIn('book_id', $request->books)
                        ->update(['returned_at' => Carbon::now()]);

            $books = Book::whereIn('id', $request->books)->update(['borrowed' => false]);

            return $this->apiResponseSuccess('Returned book successfully!', null, 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
}
