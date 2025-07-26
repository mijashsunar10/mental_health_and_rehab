<!-- resources/views/components/media.blade.php -->
@props([
    'publicId',
    'type' => 'image', // 'image' or 'video'
    'alt' => '',
    'width' => null,
    'height' => null,
    'class' => '',
    'controls' => false, // For video
    'poster' => null,   // For video thumbnail
])

@if($type === 'image')
    <img src="https://res.cloudinary.com/{{ config('cloudinary.cloud_name') }}/image/upload/{{ $width ? 'w_'.$width : '' }}{{ $height ? ',h_'.$height : '' }}/{{ $publicId }}"
         alt="{{ $alt }}"
         class="{{ $class }}"
         {{ $attributes }}>
@elseif($type === 'video')
    <video class="{{ $class }}" {{ $controls ? 'controls' : '' }} {{ $poster ? 'poster="'.$poster.'"' : '' }} {{ $attributes }}>
        <source src="https://res.cloudinary.com/{{ config('cloudinary.cloud_name') }}/video/upload/{{ $publicId }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
@endif