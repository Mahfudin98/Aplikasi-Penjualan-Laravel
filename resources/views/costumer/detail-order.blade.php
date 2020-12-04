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

<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Bukti Pembayaran</th>
                            <th scope="col">Invoice</th>
                            <th scope="col">Address</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($order->count())
                            @foreach ($order as $row)
                                    <tr>
                                        <td>
                                            @if ($row->status == 0)
                                                <a class="gray_btn" href="/costumer/payment/{{$row->invoice}}">Upload bukti pembayaran</a>
                                            @else
                                                <img class="card-img" src="{{ asset('storage/payment/' .$row->payment['proof']) }}" style="height: 100px; width: auto;" alt="{{$row->payment['proof']}}">
                                            @endif
                                        </td>

                                        <td>
                                            <div class="media">
                                                {{-- <div class="d-flex">
                                                    <img src="{{ asset('storage/products/' . $row->product->image) }}" style="height: 100px;" alt="">
                                                </div> --}}
                                                <div class="media-body">
                                                    <p>{{$row->invoice}}</p>
                                                    <a class="btn btn-danger" href="/costumer/pdf/{{$row->id}} ">Download invoice</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p> {{$row->customer_address}} </p>
                                        </td>
                                        <td>
                                            <h5>Rp.{{number_format($row->subtotal)}}</h5>
                                        </td>
                                        <td>
                                            <h5>Rp.{{number_format($row->cost)}}</h5>
                                        </td>

                                        <td>
                                            @if ($row->status == 0)
                                                <span class="badge badge-secondary">Baru</span>
                                             @elseif ($row->status == 1)
                                                <span class="badge badge-primary">Dikonfirmasi</span>
                                             @elseif ($row->status == 2)
                                                <span class="badge badge-info">Proses</span>
                                             @elseif ($row->status == 3)
                                                <span class="badge badge-warning">Dikirim</span>
                                                <form action="/costummer/order/update/{{$row->id}} " method="post">
                                                    @csrf
                                                    <input type="hidden" name="status" value="4">
                                                    <button class="btn btn-primary btn-sm" type="submit">Update ke Selesai</button>
                                                </form>
                                            @elseif ($row->status == 4)
                                                <span class="badge badge-success">Selesai</span>
                                            @endif
                                        </td>

                                    </tr>

                            @endforeach
                        @else
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="cupon_text d-flex align-items-center">
                                        <h4>Belanjaan masih kosong, klik <a href=" {{route('home.product')}} ">disini!</a> untuk mulai belanja.</h4>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
