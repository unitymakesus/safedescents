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
    @if(($services))
      @foreach($services as $service)
        <article style="background-image:url({!! $service->service_image !!})">
          <h3>{{ $service->service_title }}</h3>
          <p>Can cost up to
            <span>{{ $service->service_price }}</span>
          </p>
        </article>
      @endforeach
    @endif
  </section>

  <a href="/coverage/" class="btn">See Coverage</a>

  <section class="products" style="background-image:url({!! $products->products_image !!})">
    <div class="banner">{{$products->product_banner}}</div>
    {{$products->product_header}}

    @if(($products))
      @foreach($products->product as $product)
        <article>
          <p>Starting at</p>
          {{$product->product_price}}
          {{$product->product_description}}
          <a href="{{$product->product_link}}">Buy Now</a>
        </article>
      @endforeach
    @endif
  </section>

  <section class="testimonials">
    <div class="banner">The Latest from Safe Descents</div>
    <p>blog posts here</p>
  </section>
@endsection
