<tr{{$class}}>
  
  @if (!empty($field['args']['label_for']))
    <th scope="row">
      <label for="{{ esc_attr($field['args']['label_for']) }}">
        {{ $field['title'] }}
      </label>
    </th>
  @else
    <th scope="row">{{ $field['title'] }}</th>
  @endif

  <td>
    {!! $renderedSetting !!}
  </td>
</tr>