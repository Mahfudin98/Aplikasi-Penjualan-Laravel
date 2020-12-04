@extends('layouts.layout')

@section('title')
    Home
@endsection

@section('index')
    active
@endsection

@section('main')
<main class="site-main">

    <!--================ Hero banner start =================-->
    <section class="hero-banner">
      <div class="container">
        <div class="row no-gutters align-items-center pt-60px">
          <div class="col-5 d-none d-sm-block">
            <div class="hero-banner__img">
              <img class="img-fluid" src="{{asset('assets/img/home/hero-banner.png')}}" alt="">
            </div>
          </div>
          <div class="col-sm-7 col-lg-6 offset-lg-1 pl-4 pl-md-5 pl-lg-0">
            <div class="hero-banner__content">
              <h4>Shop is fun</h4>
              <h1>Browse Our Premium Product</h1>
              <p>Us which over of signs divide dominion deep fill bring they're meat beho upon own earth without morning over third. Their male dry. They are great appear whose land fly grass.</p>
              <a class="button button-hero" href=" {{route('home.product')}} ">Browse Now</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================ Hero banner start =================-->

    <!--================ Hero Carousel start =================-->
    <section class="section-margin mt-0">
      <div class="owl-carousel owl-theme hero-carousel">
        <div class="hero-carousel__slide">
          <img src="img/home/hero-slide1.png" alt="" class="img-fluid">
          <a href="#" class="hero-carousel__slideOverlay">
            <h3>Wireless Headphone</h3>
            <p>Accessories Item</p>
          </a>
        </div>
        <div class="hero-carousel__slide">
          <img src="img/home/hero-slide2.png" alt="" class="img-fluid">
          <a href="#" class="hero-carousel__slideOverlay">
            <h3>Wireless Headphone</h3>
            <p>Accessories Item</p>
          </a>
        </div>
        <div class="hero-carousel__slide">
          <img src="img/home/hero-slide3.png" alt="" class="img-fluid">
          <a href="#" class="hero-carousel__slideOverlay">
            <h3>Wireless Headphone</h3>
            <p>Accessories Item</p>
          </a>
        </div>
      </div>
    </section>
    <!--================ Hero Carousel end =================-->

    <!-- ================ trending product section start ================= -->
    <section class="section-margin calc-60px">
      <div class="container">
        <div class="section-intro pb-60px">
          <p>Tampil trendi dengan produk terbaru kami.</p>
          <h2>Produk <span class="section-intro__style">Terbaru</span></h2>
        </div>
        <div class="row">

          @foreach ($products as $row)
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card text-center card-product">
                <div class="card-product__img">
                  <img class="card-img" src="{{ asset('storage/products/' . $row->image) }}" alt="{{ $row->name }}">
                  <ul class="card-product__imgOverlay">
                    <li><button><i class="ti-search"></i></button></li>
                    <li><a href="{{ url('/product/' . $row->slug) }}"><button><i class="ti-shopping-cart"></i></button></a></li>
                    <li><button><i class="ti-heart"></i></button></li>
                  </ul>
                </div>
                <div class="card-body">
                  <p>{{ $row->category->name}}</p>
                  <h4 class="card-product__title"><a href="single-product.html">{{$row->name}}</a></h4>
                  <p class="card-product__price">Rp. {{ number_format($row->price) }}</p>
                </div>
              </div>
            </div>
          @endforeach

        </div>
      </div>
    </section>
    <!-- ================ trending product section end ================= -->

  </main>
@endsection
