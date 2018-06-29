{{--
  Template Name: Homepage Template
--}}

@extends('layouts.app')

@section('content')
  <section class="callout parallax" style="background-image:url({!! $callout['callout_image'] !!})">
    <div class="callout-text">
      {!! $callout['callout_text'] !!}
    </div>
  </section>

  <section class="services">
    <div class="container">
      @if(($services))
        @foreach($services as $service)
          <article style="background-image:url({!! $service['service_image'] !!})">
            <h3>{{ $service['service_title'] }}</h3>

            <div>
              <h5>Can cost up to</h5>
              <h4>{{ $service['service_price'] }}</h4>
            </div>
          </article>
        @endforeach
      @endif
    </div>

    <a href="/coverage/" class="btn">See Coverage</a>
  </section>

  <section class="products parallax" style="background-image:url({!! $products['product_image'] !!})">
    <div class="banner">{{$products['product_banner']}}</div>

    <div class="container">
      <h3>{{$products['product_header']}}</h3>

      @if(($products))
        @foreach($products['product'] as $product)
          <article>
            <p>Starting at</p>
            <h2>{{$product['product_price']}}</h2>
            <h5>{{$product['product_description']}}</h5>
            <a class="btn" href="{{$product['product_link']}}">Buy Now</a>
          </article>
        @endforeach
      @endif
    </div>
  </section>

  <section class="latestposts">
    <div class="banner">The Latest from Safe Descents</div>
    <section class="container">
      <?php $the_query = new WP_Query( 'posts_per_page=3' ); ?>
      <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
        <article>
          <?php if (has_post_thumbnail())
            the_post_thumbnail( 'thumbnail' ); ?>
          <div>
            <p class="post-title"><?php the_title(); ?></p>
            <?php the_excerpt(__('(more…)')); ?>
            <a href="<?php the_permalink() ?>">Read More</a>
          </div>
        </article>
      <?php
        endwhile;
        wp_reset_postdata();
      ?>
    </section>
    </div>
  </section>
@endsection
