@extends('layouts.layout')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendors/linericon/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendors/nouislider/nouislider.min.css')}}">

@endsection

@section('title')
    Home
@endsection

@section('main')
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Shopping Cart</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
        </ol>
      </nav>
            </div>
        </div>
</div>
</section>
<!-- ================ end banner area ================= -->

<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Action</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($cart->count())
                            @foreach ($cart as $row)
                                    <tr>
                                        <td>
                                            <form method="POST" action="{{ url('/costumert/cart/delete/'.$row->id)}}" accept-charset="UTF-8" style="display:inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger" type="submit"><i class="ti-trash"></i></button>
                                            </form>
                                        </td>
                                        <form action="/costumer/cartupdate/{{$row->id}}" method="post">
                                            @method('PATCH')
                                            @csrf
                                        <td>
                                            <div class="media">
                                                <div class="d-flex">
                                                    <img src="{{ asset('storage/products/' . $row->product->image) }}" style="height: 100px;" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <p>{{$row->product->name}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>Rp.{{number_format($row->product->price)}}</h5>
                                        </td>
                                        <td>
                                            <div class="product_count">
                                                <input type="text" name="qty" id="sst{{ $row->id }}" maxlength="12" value="{{$row->qty}}" title="Quantity:"
                                                    class="input-text qty">
                                                <input type="hidden" name="{{$row->id}}" value="{{$row->id}}">
                                                <button onclick="var result = document.getElementById('sst{{$row->id}}'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                                    class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                                <button onclick="var result = document.getElementById('sst{{$row->id}}'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                                    class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>Rp.{{ number_format($row->cart_price * $row->qty) }}</h5>
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

                        <tr class="bottom_button">
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                                <button class="button" type="submit">Update</button>
                            </form>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <h5>Subtotal</h5>
                            </td>
                            <td>
                                <h5>Rp.{{number_format($subtotal)}}</h5>
                            </td>
                        </tr>

                            {{-- <tr class="shipping_area">
                                <td>
                                </td>
                                <td class="d-none d-md-block">
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <div class="shipping_box">
                                        <div class="cupon_text d-flex align-items-center">
                                            <h5>Ringkasan Belanja</h5>
                                        </div>
                                        <ul class="list">
                                            @foreach ($cart as $row)
                                                <li><a href="#">{{$row->product->name}}: Rp.{{ number_format($row->cart_price * $row->qty) }}</a></li>
                                            @endforeach
                                            <li><a href="#">Berat: {{$weight}}gr </a></li>
                                            <li><a href="#" id="ongkir">Ongkir:  Rp.0</a></li>
                                            <li><a href="#" id="resi">Perkiraan waktu sampai:  (hari)</a></li>
                                        </ul>
                                        <h6>Total Belanja <i class="fa fa-caret-down" aria-hidden="true"></i></h6>

                                        <ul class="list">
                                            <li class="active"><a href="#" id="total"></a></li>
                                        </ul>
                                        <hr>
                                        <input type="hidden" name="city_origin" id="city_origin" value="252" required>

                                        <select class="shipping_select" id="province_id" name="province_destination" required>
                                            <option value="">Pilih Propinsi</option>
                                            @foreach ($provinces as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        <select class="shipping_select" name="city_destination" id="city_id" required>
                                            <option value="">Pilih Kabupaten/Kota</option>
                                        </select>
                                        <select class="shipping_select" name="courier" id="courier" required>
                                            <option>--Courier--</option>
                                            @foreach ($couriers as $courier => $value)
                                            <option value="{{$courier}}"> {{$value}} </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="weight" id="weight" value="{{$weight}}" required>
                                        <select class="shipping_select" name="service" id="service" required>
                                            <option>--Service--</option>
                                        </select>
                                        <input type="text" name="district_id" value=" {{Auth::guard('costumer')->user()->district_id}} " required>
                                    </div>
                                </td>
                            </tr> --}}

                            <tr class="out_button_area">
                                <td class="d-none-l">
                                </td>
                                <td class="">
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">

                                        @if ($cart->count())
                                            <a class="gray_btn" href=" {{route('home.product')}} ">Lanjutkan Berbelanja</a>
                                            <a class="primary-btn ml-2" href=" {{route('home.checkout')}} ">Checkout</a>
                                        @else
                                        <a class="primary-btn ml-2" href=" {{route('home.product')}} ">Lanjutkan Berbelanja</a>
                                        <a href=" {{route('home.checkout')}} "><button class="gray_btn" disabled="disabled">Checkout</button></a>
                                        @endif

                                    </div>
                                </td>
                            </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!--================End Cart Area =================-->
@endsection

@section('js')
    <script src="{{asset('assets/vendors/nice-select/jquery.nice-select.min.js')}}"></script>
    {{-- <script type="text/javascript">
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
            $('#resi').text('Perkiraan waktu sampai : ' + split[2])

            let subtotal = "{{ $subtotal }}"
            let total = parseInt(subtotal) + parseInt(split[1])
            $('#total').text('Rp. ' + total)
            $('#subtotal').append('<input type="text" name="subtotal" value="'+total+'" disabled required>')
        })

    </script>     --}}

@endsection

