<div class="select-field">
  <select name="{{$id}}" id="{{$id}}">
    @foreach ($options->values as $key => $value)
      <option 
        value="{{ $key }}"
        {{ selected( $adapter::get( $id ), $key ) }}
      >
        {{ ucwords(str_replace(['_', '-'], ' ', $value)) }}
      </option>
    @endforeach
  </select>
</div>
@include('DevSnippet')