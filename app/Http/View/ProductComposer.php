<?php

namespace App\Http\View;

use Illuminate\View\View;
use App\Models\Product;

class ProductComposer
{
    public function compose(View $view)
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(4);

        $view->with('products', $products);
    }
}
