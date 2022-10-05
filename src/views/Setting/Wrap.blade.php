<tr{{$class}}>
  
  <th scope="row">
    <label for="{{ $options->id }}">
      {{ $options->title }}
    </label>
  </th>

  <td>
    {!! $renderedSetting !!}
  </td>

</tr>