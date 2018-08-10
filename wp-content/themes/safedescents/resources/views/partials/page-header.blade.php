<div class="page-header">
  @if (array_key_exists('confirm', $_GET) && array_key_exists('stripe_token', $_REQUEST))
    <h1>Thank You</h1>
  @else
    <h1>{!! App::title() !!}</h1>
  @endif
</div>
