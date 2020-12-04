@extends('layouts.layout')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendors/linericon/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendors/nouislider/nouislider.min.css')}}">
<style>
    .center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50px;
    }
</style>
@endsection

@section('title')
    Order
@endsection

@section('main')
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Order Confirmation</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Shop Category</li>
        </ol>
      </nav>
            </div>
        </div>
</div>
</section>
<!-- ================ end banner area ================= -->

<!--================Order Details Area =================-->
<section class="order_details section-margin--small">
<div class="container">
  <p class="text-center billing-alert">Thank you. Your order has been received.</p>
  <div class="center">
    <a href=" /costumer/pdf/{{$order->id}} "><button class="button">Download Invoice</button></a>
  </div>
  <hr>
  <div class="row mb-5">
    <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
      <div class="confirmation-card">
        <h3 class="billing-title">Order Info</h3>
        <table class="order-rable">
            <tr>
                <td>Nama</td>
                <td>: {{$order->customer->name}}</td>
            </tr>
            <tr>
            <td>Invoice</td>
            <td>: {{$order->invoice}}</td>
            </tr>
            <tr>
            <td>Date</td>
            <td>: {{$order->created_at->format('d, M Y')}}</td>
            </tr>
            <tr>
            <td>Total</td>
            <td>: Rp. {{number_format($order->cost)}}</td>
            </tr>
        </table>
      </div>
    </div>
    <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
      <div class="confirmation-card">
        <h3 class="billing-title">Billing Address</h3>
        <table class="order-rable">
            <tr>
            <td>Alamat</td>
            <td>: {{$order->customer_address}}</td>
            </tr>
            <tr>
            <td>Kecamatan</td>
            <td>: {{$order->district->name}} </td>
            </tr>
            <tr>
            <td>Kota/Kabupaten</td>
            <td>: {{$order->citie->name}}</td>
            </tr>
            <tr>
            <td>Postcode</td>
            <td>: {{$order->citie->postal_code}}</td>
            </tr>
        </table>
      </div>
    </div>
    <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
      <div class="confirmation-card">
        <h3 class="billing-title">Shipping Address</h3>
        <table class="order-rable">
          <tr>
            <td>Street</td>
            <td>: 56/8 panthapath</td>
          </tr>
          <tr>
            <td>City</td>
            <td>: Dhaka</td>
          </tr>
          <tr>
            <td>Country</td>
            <td>: Bangladesh</td>
          </tr>
          <tr>
            <td>Postcode</td>
            <td>: 1205</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="order_details_table">
    <h2>Order Details</h2>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Product</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total</th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                  <p>{{$order_detail->product->name}}</p>
                </td>
                <td>
                  <h5>x {{$order_detail->qty}}</h5>
                </td>
                <td>
                  <p>Rp. {{number_format($order_detail->price * $order_detail->qty)}}</p>
                </td>
            </tr>
          <tr>
            <td>
              <h4>Subtotal</h4>
            </td>
            <td>
              <h5></h5>
            </td>
            <td>
              <p>Rp. {{number_format($order->subtotal)}}</p>
            </td>
          </tr>
          <tr>
            <td>
              <h4>Shipping</h4>
            </td>
            <td>
              <h5></h5>
            </td>
            <td>
              <p>Flat rate: RP. {{number_format($order->shipping)}}</p>
            </td>
          </tr>
          <tr>
            <td>
              <h4>Total</h4>
            </td>
            <td>
              <h5></h5>
            </td>
            <td>
              <h4>Rp. {{number_format($order->cost)}}</h4>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</section>
<!--================End Order Details Area =================-->
@endsection
