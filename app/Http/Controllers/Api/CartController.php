<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MarketplaceCart;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(): JsonResponse
    {
        $user = User::first();

        $cart = $user->carts()->where('paid_at', null)->first();

        return response()->json($cart);
    }

    public function show(MarketplaceCart $cart): JsonResponse
    {
        return response()->json($cart);
    }

    public function store(Request $request): JsonResponse
    {
        $user = User::first();

        $cart = $user->carts()->where('paid_at', null)->first();
        $cartItems = $cart->items ?? [];

        $cartItems[] = $request->item;

        if ($cart) {
            $cart->items = $cartItems;
            $cart->save();
        } else {
            $user->carts()->save(
                new MarketplaceCart(['items' => $cartItems])
            );
        }

        return response()->json(['message' => 'Item was added successfully to cart']);
    }

    public function destroy(MarketplaceCart $cart): JsonResponse
    {
        $cart->update([
            'paid_at' => now()
        ]);

        return response()->json(['message' => 'Your cart was successfully paid.']);
    }
}
