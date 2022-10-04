<section class="ardent-intent-options-section">
  <h2>{{ $title }}</h2>
  <table class="form-table">
    @foreach ($settings as (object)$setting)
      {!! 
        call_user_func(
          $setting->callback, 
          $setting->args
        )
      !!}
    @endforeach
  </table>
</section>