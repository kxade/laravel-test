@props(['name' => ''])

@error($name)
    <div class="small text-danger pt-2">
        {{ $message }}               
    </div>
@enderror