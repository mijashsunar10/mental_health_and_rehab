<img 
    src="https://res.cloudinary.com/{{ config('cloudinary.cloud_name') }}/image/upload/{{ $publicId }}"
    alt="{{ $alt }}"
    @isset($width) width="{{ $width }}" @endisset
    @isset($height) height="{{ $height }}" @endisset
    class="{{ $class ?? '' }}"
    {{ $attributes ?? '' }}
>