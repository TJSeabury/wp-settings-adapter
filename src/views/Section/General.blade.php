<section class="ardent-intent-options-section">
  <h2>{{ $title }}</h2>
  <table class="form-table">
    {{-- Apperently I cannot cast $section to object?? --}}
    @foreach ($settings as $setting)
      {!! 
        call_user_func(
          $setting['callback'], 
          $setting['args']
        )
      !!}
    @endforeach
  </table>
</section>