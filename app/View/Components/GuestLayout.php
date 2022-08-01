<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GuestLayout extends Component
{
    public string $title;
    public string $google;

    public function __construct(string $title = null, string $google = null)
    {
        $this->title = $title ?? config('app.name');
        $this->google = $google ?? '';
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.guest');
    }
}
