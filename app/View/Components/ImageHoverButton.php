<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImageHoverButton extends Component
{
    public $image;
    public $alt;
    public $buttonText;
    public $buttonLink;

    public function __construct($image, $alt = '', $buttonText = 'Preview', $buttonLink = '#')
    {
        $this->image = $image;
        $this->alt = $alt;
        $this->buttonText = $buttonText;
        $this->buttonLink = $buttonLink;
    }

    public function render()
    {
        return view('components.image-hover-button');
    }
}
