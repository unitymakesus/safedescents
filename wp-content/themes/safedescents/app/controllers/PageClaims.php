<?php

namespace App;

use Sober\Controller\Controller;

class PageClaims extends Controller
{
  public function hospital(){
    return get_field('hospital');
  }

  public function home(){
    return get_field('home');
  }

}
