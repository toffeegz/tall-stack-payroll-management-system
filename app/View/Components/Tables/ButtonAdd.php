<?php

namespace App\View\Components\Tables;

use Illuminate\View\Component;

class ButtonAdd extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $wire;
    public function __construct($wire)
    {
        $this->wire = $wire;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tables.button-add');
    }
}
