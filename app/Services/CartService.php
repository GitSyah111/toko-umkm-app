<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;

class CartService
{
    /**
     * Add or increment a product in the user's cart.
     *
     * @param int $userId
     * @param int $productId
     * @param int $quantity
     * @return CartItem
     */
    public function addToCart(int $userId, int $productId, int $quantity): CartItem
    {
        $cart = Cart::firstOrCreate(['user_id' => $userId]);
        
        $cartItem = $cart->items()->where('product_id', $productId)->first();
        
        if ($cartItem) {
            $cartItem->increment('kuantitas', $quantity);
            // Refresh to get the updated attributes
            $cartItem->refresh();
        } else {
            $cartItem = $cart->items()->create([
                'product_id' => $productId,
                'kuantitas' => $quantity,
            ]);
        }

        return $cartItem;
    }
}
