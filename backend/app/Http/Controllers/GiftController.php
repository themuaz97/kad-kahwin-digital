<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Http\Requests\StoreGiftRequest;
use App\Http\Requests\UpdateGiftRequest;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGiftRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Gift $gift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGiftRequest $request, Gift $gift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gift $gift)
    {
        //
    }
}
