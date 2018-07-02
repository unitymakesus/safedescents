<?php

namespace App;

use Sober\Controller\Controller;
use WP_Query;

class App extends Controller
{
    public function products() {
        $args = array(
          'post_type' => 'product',
          'posts_per_page' => -1,
          'order' => 'ASC',
          );
        $products = new WP_Query( $args );
        return $products;
    }

    // TODO: How can we pass a variable to this function so we can use it in multiple places?
    // public function pass_options($product) {
    //   $variations = $product->get_available_variations();
    //   $passes = array(
    //     'season-pass' => array(
    //       'label' => 'Per Season'
    //     ),
    //     'daily-pass' => array(
    //       'label' => 'Per Day'
    //     )
    //   );
    //
    //   foreach ($variations as $variation) {
    //     if ($pass_duration = $variation['attributes']['attribute_pa_pass']) {
    //       $passes[$pass_duration]['price'] = $variation['display_price'];
    //       $passes[$pass_duration]['variation_id'] = $variation['variation_id'];
    //       $passes[$pass_duration]['attributes'] = $variation['attributes'];
    //     }
    //   }
    //
    //   return $passes;
    // }


    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }
}
