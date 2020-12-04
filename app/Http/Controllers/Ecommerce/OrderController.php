<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Citie;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use PDF;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index($invoice){
        $cart = Cart::where('customer_id', Auth::guard('costumer')->user()->id)->get();
        $order = Order::where('invoice', $invoice)->first();



        $order_detail = OrderDetail::where('order_id', $order['id'])->first();



        $subtotal = collect($cart)->sum(function($q){
            return $q['qty'] * $q['cart_price'];
        });
        $weight = collect($cart)->sum(function($q){
            return $q['qty'] * $q['cart_weight'];
        });

        // foreach ($cart as $row) {
        //     $cost = RajaOngkir::ongkosKirim([
        //         'origin'       => 252,
        //         'destination'  => $row->customer->city_id,
        //         'weight'       => $weight,
        //         'courier'      => 'jne',
        //     ])->get();
        // }

        return view('costumer.order', compact('cart', 'order', 'subtotal', 'weight', 'order_detail'));
    }

    public function checkout(){
        $cart = Cart::where('customer_id', Auth::guard('costumer')->user()->id)->get();

        $subtotal = collect($cart)->sum(function($q){
            return $q['qty'] * $q['cart_price'];
        });
        $weight = collect($cart)->sum(function($q){
            return $q['qty'] * $q['cart_weight'];
        });

        // $couriers = Courier::pluck('title', 'code');
        // $provinces = Province::orderBy('created_at', 'DESC')->get();

        foreach ($cart as $row) {
            $cost = RajaOngkir::ongkosKirim([
                'origin'       => 252,
                'destination'  => $row->customer->citie_id,
                'weight'       => $weight,
                'courier'      => 'jne',
            ])->get();
        }


        return view('costumer.checkout', compact('cart', 'subtotal', 'weight', 'cost'));
    }

    public function processCheckout(Request $request)
    {
        $cart = Cart::where('customer_id', Auth::guard('costumer')->user()->id)->get();

        $order = Order::create([
            'invoice'           => $request->invoice,
            'customer_id'       => $request->customer_id,
            'customer_name'     => $request->customer_name,
            'customer_phone'    => $request->customer_phone,
            'customer_address'  => $request->customer_address,
            'district_id'       => $request->district_id,
            'citie_id'          => $request->citie_id,
            'subtotal'          => $request->subtotal,
            'cost'              => $request->cost,
            'shipping'          => $request->shipping,
            'status'            => $request->status
        ]);

        foreach ($cart as $row) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $row['product_id'],
                'price' => $row['cart_price'],
                'qty' => $row['qty'],
                'weight' => $row['cart_weight']
            ]);
        }

        foreach ($cart as $row){
            $product = Product::find($row['product_id']);
            $product->update([
                'stock' => $product['stock'] - $row['qty'],
            ]);
        }

        foreach ($cart as $row){
            $cart = Cart::find($row['id']);
            $cart->delete();
        }

        return redirect('/costumer/order/'.$order->invoice);
    }

    public function generatePDF($id)
    {
        $order = Order::where('id', $id)->get();
        foreach ($order as $row) {
            $citie = Citie::where('id',$row->citie_id)->get();
            $order_detail = OrderDetail::where('order_id', $row->id)->get();
        }

        $pdf = PDF::loadView('costumer.invoice', compact('order', 'citie', 'order_detail'));
        return $pdf->download('Invoice.pdf');
    }

    public function detail(){
        $order = Order::where('customer_id', Auth::guard('costumer')->user()->id)->get();

        return view('costumer.detail-order', compact('order'));
    }

    public function paymentForm($invoice){
        $order = Order::where('invoice', $invoice)->first();

        return view('costumer.payment', compact('order'));
    }

    public function payment(Request $request){

        $order = Order::where('invoice', $request->invoice)->first();
        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/payment', $filename);
        }
            Payment::create([
                'order_id' => $request->order_id,
                'name' => $request->name,
                'transfer_to' => $request->transfer_to,
                'transfer_date' => Carbon::parse($request->transfer_date)->format('Y-m-d'),
                'amount' => $request->amount,
                'proof' => $filename,
                'status' => false
            ]);

            $order->update(['status' => 1]);
            DB::commit();
            return redirect(route('home.orderdetail'));

    }

    public function update(Request $request){
        $orders = Order::where('id', $request->id)->update([
            'status' => $request['status']
            ]);

        return redirect(route('home.orderdetail'));
    }
}
