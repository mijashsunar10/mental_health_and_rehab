<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CloudinaryImage extends Component
{
    public $publicId;
    public $alt;
    public $width;
    public $height;
    public $class;
    public $format;
    public $quality;
    public $crop;
    public $gravity;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $publicId,
        $alt = '',
        $width = null,
        $height = null,
        $class = '',
        $format = 'webp',
        $quality = 'auto',
        $crop = 'fill',
        $gravity = 'auto'
    ) {
        $this->publicId = $publicId;
        $this->alt = $alt;
        $this->width = $width;
        $this->height = $height;
        $this->class = $class;
        $this->format = $format;
        $this->quality = $quality;
        $this->crop = $crop;
        $this->gravity = $gravity;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.cloudinary-image');
    }
}