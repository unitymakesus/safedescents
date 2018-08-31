{{--
  Template Name: Homepage Template
--}}

@extends('layouts.app')

@section('content')
<div class="banner header-banner">{{ $banner }}</div>

  <section class="callout" style="background-image: url({!! $callout['callout_image'] !!})">

    <div class="callout-text">
      {!! $callout['callout_text'] !!}
    </div>
  </section>

  <section class="services">
    <div class="row">
      @if(($services))
        @foreach($services as $service)
          <article class="col-xs-12 col-sm-4" style="background-image:url({!! $service['service_image'] !!})">
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

  <div class="banner">{{$products['product_banner']}}</div>

  <section class="products" style="background-image: url({!! $products['product_image'] !!})">
    <div class="products-container">
      <h3>{{$products['product_header']}}</h3>

      @if(($products))
        @foreach($products['product'] as $product)
          <article>
            <p>Starting at</p>
            <p class="price">{{$product['product_price']}}</p>
            <p class="desc">{{$product['product_description']}}</p>
            <a class="btn" href="{{$product['product_link']}}">Buy Now</a>
          </article>
        @endforeach
      @endif
    </div>
  </section>

  <div class="banner">The Latest from Safe Descents</div>
  <section class="latestposts row">
    <?php $the_query = new WP_Query( 'posts_per_page=3' ); ?>
    <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
      <article class="col-xs-12 col-sm-4">
        <?php if (has_post_thumbnail())
          the_post_thumbnail( 'thumbnail' ); ?>
        <div>
          <p class="post-title"><?php the_title(); ?></p>
          <?php the_excerpt() ?>

          <?php if( get_field('external_article_link') ): ?>
            <a target="_blank" href="<?php echo get_field('external_article_link') ?>">Read Article</a>

          <?php else : ?>
            <a href="<?php the_permalink() ?>">View More</a>
          <?php endif; ?>
        </div>
      </article>
    <?php
      endwhile;
      wp_reset_postdata();
    ?>
  </section>
@endsection
