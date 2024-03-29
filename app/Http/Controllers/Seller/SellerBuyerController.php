<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellerBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $buyers = $seller->products()->whereHas('transactions')->with('transactions.buyer')
            ->get()->pluck('transactions')->collapse()->pluck('buyer')->unique()->values();

        return $this->showAll($buyers);
    }

}
