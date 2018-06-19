{{--
  Template Name: Homepage Template
--}}

@extends('layouts.app')

@section('content')
  <section class="callout" style="background-image:url({!! $callout->callout_image !!})">
    <div class="callout-text">
      {!! $callout->callout_text !!}
    </div>
  </section>

  <section class="services">
    <div class="container">
      @if(($services))
        @foreach($services as $service)
          <article style="background-image:url({!! $service->service_image !!})">
            <h3>{{ $service->service_title }}</h3>

            <div>
              <h5>Can cost up to</h5>
              <h4>{{ $service->service_price }}</h4>
            </div>
          </article>
        @endforeach
      @endif
    </div>

    <a href="/coverage/" class="btn">See Coverage</a>
  </section>

  <section class="products" style="background-image:url({!! $products->product_image !!})">
    <div class="banner">{{$products->product_banner}}</div>

    <div class="container">
      <h3>{{$products->product_header}}</h3>

      @if(($products))
        @foreach($products->product as $product)
          <article>
            <p>Starting at</p>
            <h2>{{$product->product_price}}</h2>
            <h5>{{$product->product_description}}</h5>
            <a class="btn" href="{{$product->product_link}}">Buy Now</a>
          </article>
        @endforeach
      @endif
    </div>
  </section>

  <section class="testimonials">
    <div class="banner">The Latest from Safe Descents</div>
    <p>blog posts here</p>
  </section>
@endsection
