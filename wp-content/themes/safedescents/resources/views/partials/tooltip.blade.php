@if ($products->have_posts())
  @while ($products->have_posts())
    @php
      // WP post object
      $products->the_post();
      // WC product object
      global $product;
      $product_id = $product->get_id();
    @endphp

    <div class="tooltip" id="{{the_title()}}">
      <div class="state">{{ the_title() }}</div>
      @if ($product->is_type('variable'))
        @php
          $variations = $product->get_available_variations();
          $passes = array(
            'season-pass' => array(
              'label' => 'Per Season'
            ),
            'daily-pass' => array(
              'label' => 'Per Day'
            )
          );

          foreach ($variations as $variation) {
            if ($pass_duration = $variation['attributes']['attribute_pa_pass']) {
              $passes[$pass_duration]['price'] = $variation['display_price'];
              $passes[$pass_duration]['variation_id'] = $variation['variation_id'];
              $passes[$pass_duration]['attributes'] = $variation['attributes'];
            }
          }
        @endphp

        @foreach ($passes as $key => $pass)
          <div class="variation">
            <div class="price">
              ${{ $pass['price'] }}
            </div>
            <div class="duration">
              {{ $pass['label'] }}
            </div>
            <div class="buy">

              <a rel="nofollow"
                 href="{!! do_shortcode('[add_to_cart_url id="' . $pass['variation_id'] . '"]') !!}"
                 data-quantity="1"
                 data-product_id="{{ $product_id }}"
                 data-variation_id="{{ $pass['variation_id'] }}"
                 data-variation="{{ json_encode($pass['attributes']) }}"
                 class="button">Buy Now</a>
            </div>
          </div>
        @endforeach

      @endif
    </div>
  @endwhile
@endif

@php (wp_reset_postdata())
