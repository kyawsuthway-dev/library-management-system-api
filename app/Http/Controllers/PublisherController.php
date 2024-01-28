<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublisherRequests\StorePublisherRequest;
use App\Http\Requests\PublisherRequests\UpdatePublisherRequest;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        try {
            $publishers = Publisher::all();

            return $this->apiResponseSuccess('Publishers retrieved successfully!', PublisherResource::collection($publishers), 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function store(StorePublisherRequest $request)
    {
        try {
            $validated_request = $request->safe();

            $publisher = Publisher::create($validated_request->toArray());

            return $this->apiResponseSuccess('Publisher created successfully!', new PublisherResource($publisher), 201);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
    
    public function show(Publisher $publisher)
    {
        return $this->apiResponseSuccess('Publisher retrieved successfully!', new PublisherResource($publisher), 200);
    }

    public function update(Publisher $publisher, UpdatePublisherRequest $request)
    {
        try {
            $validated_request = $request->safe();

            $publisher->update($validated_request->toArray());

            return $this->apiResponseSuccess('Publisher updated successfully!', new PublisherResource($publisher), 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function destroy(Publisher $publisher)
    {
        try {
            $publisher->delete();

            return $this->apiResponseSuccess('Publisher removed!', null, 204);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
}
