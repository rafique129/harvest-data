<?php

namespace App\View\Components\Cms;

use Illuminate\View\Component;

class MainHeader extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $heading;
    public function __construct($heading = 'Heading')
    {
        $this->heading = $heading;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cms.main-header');
    }
}
