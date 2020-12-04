@extends('layouts.layout')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('assets/vendors/linericon/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendors/nouislider/nouislider.min.css')}}">
@endsection

@section('title')
    Checkout
@endsection

@section('main')
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Product Checkout</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ================ end banner area ================= -->


<!--================Checkout Area =================-->
<section class="checkout_area section-margin--small">
<div class="container">
    <div class="billing_details">
        <div class="row">
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
                <div class="col-lg-8">
                    <h3>Billing Details</h3>
            <form class="row contact_form" action=" {{route('home.checkoutproses')}} " method="post" novalidate="novalidate">
                @csrf
                        <div class="col-md-6 form-group p_star">
                            <input type="hidden" name="invoice" value=" {{Str::random(4) . '-' . time()}} " required>
                            <input type="hidden" name="customer_id" value=" {{Auth::guard('costumer')->user()->id}} " required>
                            <input type="text" class="form-control" id="first" name="customer_name" value=" {{Auth::guard('costumer')->user()->name}} " required>
                            <span class="placeholder" data-placeholder="First name"></span>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="customer_phone" value=" {{Auth::guard('costumer')->user()->phone_number}} " required>
                            <span class="placeholder" data-placeholder="Last name"></span>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="customer_address" value="{{Auth::guard('costumer')->user()->address}}" required>
                            <input type="hidden" class="form-control" name="district_id" value="{{Auth::guard('costumer')->user()->district_id}}" required>
                            <input type="hidden" class="form-control" name="citie_id" value="{{Auth::guard('costumer')->user()->citie_id}}" required>
                            <input type="hidden" class="form-control" name="subtotal" value="{{ $subtotal }}" required>
                            <input type="hidden" class="form-control" name="cost" value="{{ $subtotal + $cost[0]['costs'][1]['cost'][0]['value'] }}" required>
                            <input type="hidden" class="form-control" name="shipping" value="{{ $cost[0]['costs'][1]['cost'][0]['value'] }}" required>
                            <input type="hidden" class="form-control" name="status" value="0" required>
                        </div>
                        {{-- <div class="col-md-6 form-group">
                            <select class="country_select" id="province_id" name="province_destination" required>
                                <option value="">Pilih Propinsi</option>
                                @foreach ($provinces as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <select class="country_select" name="city_destination" id="city_id" required>
                                <option value="">Pilih Kabupaten/Kota</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <select class="country_select" name="courier" id="courier" required>
                                <option>--Courier--</option>
                                @foreach ($couriers as $courier => $value)
                                    <option value="{{$courier}}"> {{$value}} </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="weight" id="weight" value="{{$weight}}" required>
                        <div class="col-md-6 form-group">
                            <select class="country_select" name="service" id="service" required>
                                <option>--Service--</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <select class="country_select" name="cost" id="cost" required>
                                <option>--Service--</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <select class="country_select" name="shipping" id="shipping" required>
                                <option>--Service--</option>
                            </select>
                        </div> --}}

                </div>
                <div class="col-lg-4">
                    <div class="order_box">
                        <h2>Your Order</h2>
                        <ul class="list">
                            <li><a href="#"><h4>Product <span>Total</span></h4></a></li>
                            @foreach ($cart as $row)
                                <li><a href="#">{{$row->product->name}} <span class="middle">x {{$row->qty}} </span> <span class="last">Rp. {{ number_format($row->cart_price * $row->qty) }} </span></a></li>
                            @endforeach
                        </ul>
                        <ul class="list list_2">
                            <li><a href="#">Subtotal <span>Rp. {{ number_format($subtotal) }}</span></a></li>
                            <li><a href="#">Kurir <span id="ongkir">{{ ($cost[0]['code']) }}</span></a></li>
                            <li><a href="#">Ongkir <span id="ongkir"> Rp. {{ number_format($cost[0]['costs'][1]['cost'][0]['value']) }} </span></a></li>
                            <li><a href="#">Perkiraan waktu sampai <span id="ongkir">({{ ($cost[0]['costs'][1]['cost'][0]['etd']) }})Hari</span></a></li>

                            <li><a href="#">Total <span id="total">Rp. {{ number_format($subtotal + $cost[0]['costs'][1]['cost'][0]['value']) }}</span></a></li>
                        </ul>
                        <div class="text-center">
                            <button class="button button-paypal" type="submit">Bayar Pesanan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
<!--================End Checkout Area =================-->
@endsection

{{-- @section('js')
    <script type="text/javascript">
        $('#province_id').on('change', function() {
            $.ajax({
                url: "{{ url('/api/city') }}",
                type: "GET",
                data: { province_id: $(this).val() },
                success: function(html){

                    $('#city_id').empty()
                    $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>')
                    $.each(html.data, function(key, item) {
                        $('#city_id').append('<option value="'+item.id+'">'+item.name+'</option>')
                    })
                }
            });
        })

        $('#courier').on('change', function() {
            $('#service').empty()
            $('#service').append('<option value="">Loading...</option>')
            $.ajax({
                url:"{{ route('home.cekongkir') }}",
                type: "POST",
                data: {
                        _token:              $("meta[name='csrf-token']").attr("content"),
                        city_origin:         $('input[name=city_origin]').val(),
                        city_destination:    $('select[name=city_destination]').val(),
                        courier:             $('select[name=courier]').val(),
                        weight:              $('#weight').val(),
                    },

                success: function(response){
                    $('#service').empty();
                    $('#service').append('<option value="">Pilih service</option>')
                    $.each(response[0]['costs'], function (key, value) {
                        $('#service').append('<option>'+response[0].code.toUpperCase()+' : <strong>'+value.service+'</strong>, '+value.cost[0].value+', ('+value.cost[0].etd+' hari)</option>')
                    });
                }
            });
        })

        $('#service').on('change', function() {
            let split = $(this).val().split(',')
            $('#ongkir').text('Ongkir : Rp. ' + split[1])


            let subtotal = "{{ $subtotal }}"
            let total = parseInt(subtotal) + parseInt(split[1])
            $('#total').text('Rp. ' + total)
            $('#cost').append('<option value="'+total+'">'+total+'</option>')
            $('#shipping').append('<option value="'+split[1]+'">'+split[1]+'</option>')
            // $('#subtotal').append('<input type="text" class="form-control" name="shipping" value="'+split[1]+'" disabled required>')
            // $('#resi').append('<input type="text" class="form-control" name="cost" value="'+total+'" disabled required>')
        })

    </script>
@endsection --}}
