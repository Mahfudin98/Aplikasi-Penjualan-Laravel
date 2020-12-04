<?php

namespace App\Http\View;

use Illuminate\View\View;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartComposer
{
    public function compose(View $view)
    {
        if (Auth::guard('costumer')->check()) {
            $cart = Cart::where('customer_id', Auth::guard('costumer')->user()->id)->get();
        } else {
            $cart = Cart::where('customer_id', Auth::guard('costumer')->user())->get();
        }

        $view->with('cart', $cart);
    }
}
