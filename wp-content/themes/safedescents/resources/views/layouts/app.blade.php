<!doctype html>
<html @php language_attributes() @endphp>
  @include('partials.head')
  @if(array_key_exists('configuration_id', $_GET))
    <body @php body_class('checkout-process') @endphp>
  @else
    <body @php body_class() @endphp>
  @endif
    @if (!is_user_logged_in())
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K6GNLPH"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
    @endif
    @php do_action('get_header') @endphp
    @include('partials.header')
    <div id="buy-now-drawer">
      @include('partials.buy-now')
    </div>
    <div class="wrap" role="document">
      <div class="content">
        <main class="main">
          @yield('content')
        </main>
        @if (App\display_sidebar())
          <aside class="sidebar">
            @include('partials.sidebar')
          </aside>
        @endif
      </div>
    </div>
    @php do_action('get_footer') @endphp
    @include('partials.footer')
    @php wp_footer() @endphp
  </body>
</html>
