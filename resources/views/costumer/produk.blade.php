@extends('layouts.layout')

@section('title')
    Produk
@endsection

@section('produk')
active
@endsection

@section('main')
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Produk</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Produk</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

  <section class="section-margin--small mb-5">
    <div class="container">
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
          <div class="sidebar-categories">
            <div class="head">Browse Categories</div>
            <ul class="main-categories">
              <li class="common-filter">
                <ul>
                    @foreach ($categories as $category)
                        <li class="filter-list">
                            <strong><a href="{{ url('/category/' . $category->slug) }}">{{ $category->name }}</a></strong>

                            @foreach ($category->child as $child)
                                <ul class="list" style="display: block">
                                    <li>
                                        <a href="{{ url('/category/' . $child->slug) }}">{{ $child->name }}</a>
                                    </li>
                                </ul>
                            @endforeach
                        </li>
                    @endforeach
                </ul>
              </li>
            </ul>
          </div>
          {{-- <div class="sidebar-filter">
            <div class="top-filter-head">Product Filters</div>
            <div class="common-filter">
              <div class="head">Brands</div>
              <form action="#">
                <ul>
                  <li class="filter-list"><input class="pixel-radio" type="radio" id="apple" name="brand"><label for="apple">Apple<span>(29)</span></label></li>
                  <li class="filter-list"><input class="pixel-radio" type="radio" id="asus" name="brand"><label for="asus">Asus<span>(29)</span></label></li>
                  <li class="filter-list"><input class="pixel-radio" type="radio" id="gionee" name="brand"><label for="gionee">Gionee<span>(19)</span></label></li>
                  <li class="filter-list"><input class="pixel-radio" type="radio" id="micromax" name="brand"><label for="micromax">Micromax<span>(19)</span></label></li>
                  <li class="filter-list"><input class="pixel-radio" type="radio" id="samsung" name="brand"><label for="samsung">Samsung<span>(19)</span></label></li>
                </ul>
              </form>
            </div>
            <div class="common-filter">
              <div class="head">Color</div>
              <form action="#">
                <ul>
                  <li class="filter-list"><input class="pixel-radio" type="radio" id="black" name="color"><label for="black">Black<span>(29)</span></label></li>
                  <li class="filter-list"><input class="pixel-radio" type="radio" id="balckleather" name="color"><label for="balckleather">Black
                      Leather<span>(29)</span></label></li>
                  <li class="filter-list"><input class="pixel-radio" type="radio" id="blackred" name="color"><label for="blackred">Black
                      with red<span>(19)</span></label></li>
                  <li class="filter-list"><input class="pixel-radio" type="radio" id="gold" name="color"><label for="gold">Gold<span>(19)</span></label></li>
                  <li class="filter-list"><input class="pixel-radio" type="radio" id="spacegrey" name="color"><label for="spacegrey">Spacegrey<span>(19)</span></label></li>
                </ul>
              </form>
            </div>
            <div class="common-filter">
              <div class="head">Price</div>
              <div class="price-range-area">
                <div id="price-range"></div>
                <div class="value-wrapper d-flex">
                  <div class="price">Price:</div>
                  <span>$</span>
                  <div id="lower-value"></div>
                  <div class="to">to</div>
                  <span>$</span>
                  <div id="upper-value"></div>
                </div>
              </div>
            </div>
          </div> --}}
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
          <!-- Start Filter Bar -->
          <div class="filter-bar d-flex flex-wrap align-items-center">
            <div class="sorting">
              <select>
                <option value="1">Default sorting</option>
                <option value="1">Default sorting</option>
                <option value="1">Default sorting</option>
              </select>
            </div>
            <div class="sorting mr-auto">
              <select>
                <option value="1">Show 12</option>
                <option value="1">Show 12</option>
                <option value="1">Show 12</option>
              </select>
            </div>
            <div>
              <div class="input-group filter-bar-search">
                <input type="text" placeholder="Search">
                <div class="input-group-append">
                  <button type="button"><i class="ti-search"></i></button>
                </div>
              </div>
            </div>
          </div>
          <!-- End Filter Bar -->
          <!-- Start Best Seller -->
          <section class="lattest-product-area pb-40 category-list">
            <div class="row">
                @forelse ($products as $row)
                  <div class="col-md-6 col-lg-4">
                    <div class="card text-center card-product">
                      <div class="card-product__img">
                        <img class="card-img" src="{{ asset('storage/products/' . $row->image) }}" alt="{{ $row->name }}">
                        <ul class="card-product__imgOverlay">
                          <li><button><i class="ti-search"></i></button></li>
                          <li><button><i class="ti-shopping-cart"></i></button></li>
                          <li><button><i class="ti-heart"></i></button></li>
                        </ul>
                      </div>
                      <div class="card-body">
                        <p>{{ $row->category->name}}</p>
                        @if(Auth::guard('costumer')->check())
                            <h4 class="card-product__title"><a href="{{ url('/costumer/product/' . $row->slug) }}">{{ $row->name }}</a></h4>
                        @else
                            <h4 class="card-product__title"><a href="{{ url('/product/' . $row->slug) }}">{{ $row->name }}</a></h4>
                        @endif
                        <p class="card-product__price">Rp. {{ number_format($row->price) }}</p>
                      </div>
                    </div>
                  </div>

                @empty
                    <div class="col-md-12">
                        <h3 class="text-center">Tidak ada produk</h3>
                    </div>
                @endforelse
            </div>
          </section>
          <!-- End Best Seller -->
        </div>
      </div>
    </div>
  </section>
@endsection

@section('js')
    <script src="{{asset('assets/vendors/nice-select/jquery.nice-select.min.js')}}"></script>
@endsection
