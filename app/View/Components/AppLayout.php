<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public string $title;

    public function __construct(string $title = null)
    {
        $this->title = $title ?? config('app.name');
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app');
    }
}
