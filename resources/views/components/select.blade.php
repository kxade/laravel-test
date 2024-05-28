@props(['options' => [], 'value' => null])

<select {{ $attributes->class([
    'form-control'])
    }}>
    
    @foreach($options as $key => $text)
        <option value="{{ $key }}" {{ ($key == $value) ? 'selected': '' }}>
            {{ $text }}
        </option>
    @endforeach

</select>