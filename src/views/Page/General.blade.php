<div class="ardent-intent-options-page">
	<header>
		<h1>{{ $title }}</h1>
		<p>{{ $description }}</p>
	</header>
	<form action="options.php" method="post">
		{{-- 
      Output security fields for the registered setting.
		  Output setting sections and their fields.
		  Sections are registered for the settings slug, each field is registered to a specific section.  
    --}}
		{!! settings_fields( $slug ) !!}

		<div class="ardent-intent-sections-wrapper">
		@foreach ($sections as (object)$section)
      @if ($section->callback)
        {!! 
          call_user_func(
            $section->callback,
            $section
          ) 
        !!}
      @endif
    @endforeach
		</div>
		{{-- Output save settings button. --}}
    {!! submit_button( 'Save Settings' ) !!}
	</form>
</div>