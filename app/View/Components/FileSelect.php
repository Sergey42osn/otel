<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FileSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    // public $url;
    public $images;
    public function __construct($images = null)
    {
        // $this->url = $url;
        $this->images = $images;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.file-select');
    }
}
