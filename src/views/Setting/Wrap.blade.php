<tr class="wp-settings-adapter-row">
  
  <th scope="row">
    @if ($options->label)
      <label for="{{ $options->id }}">
        <h3>{{ $options->title }}</h3>
      </label>
    @else
    <h3>{{ $options->title }}</h3>
    @endif
  </th>

  <td>
    {!! $view->render() !!}
  </td>

</tr>