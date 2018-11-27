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

    public function bottomcontent(){
      return get_field('bottom_content');
    }

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
