<div class="wp-settings-adapter-toggle">
	<div class="slidebox">
		<input 
      type="checkbox" 
      id="{{ $id }}" 
      name="{{ $id }}" 
      value="1" 
      {{ checked( '1', $adapter::get( $id ) ) }} 
    >
		<label for="{{ $id }}"></label>
	</div>
  <p>{{ $desc }}</p>
</div>
@include('DevSnippet')
