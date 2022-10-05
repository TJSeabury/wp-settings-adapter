<div class="text_field">
	<input 
    type="text" 
    id="{{ $id }}" 
    name="{{ $id }}" 
    value="{{ $adapter::get( $id ) }}" 
  >
	<p class="description">
    {{ $desc }}
  </p>
</div>
@include('DevSnippet')