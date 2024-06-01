@props(['value' => ''])

<input {{ $attributes->class([
    'form-control',
])->merge([
    'type' => 'text',
    // 'value'=> (request()->old($name) ?: $value),
    'value'=> (request()->old($attributes->get('name')) ?: $value),
])}}>
