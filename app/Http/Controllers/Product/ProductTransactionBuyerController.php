<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductTransactionBuyerController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        $rules = [

            'quantity' => 'required|integer|min:1',
        ];
        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse('Buyer and Seller Must Not Be The Same', 409);
        }
        if (!$buyer->isVerified()) {
            return $this->errorResponse('Buyer must be verified', 409);
        }
        if (!$product->seller->isVerified()) {
            return $this->errorResponse('seller must be verified', 409);
        }
        if (!$product->isAvailable()) {
            return $this->errorResponse('Product must be available', 409);
        }
        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('quantity is bigger than exist', 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            return $this->showOne($transaction, 201);

        });
    }

}
