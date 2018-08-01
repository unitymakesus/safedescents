<?php

namespace App;

use Sober\Controller\Controller;

class PageHomepage extends Controller
{
  public function banner() {
    return get_field('banner');
  }
  public function callout(){
    return get_field('callout');
  }

  public function services(){
    return get_field('services');
  }

  public function products(){
    return get_field('products');
  }
}
