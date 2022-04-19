<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class SearchInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $placeholder;
    public $name;
    public function __construct($placeholder, $name)
    {
        $this->placeholder = $placeholder;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.search-input');
    }
}
