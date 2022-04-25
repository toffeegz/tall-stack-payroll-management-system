<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class SettingsComponent extends Component
{
    public $page_name;
    public function mount()
    {
        $this->page_name = 'company_information';
    }

    public function render()
    {
        return view('livewire.settings.settings-component')
        ->layout('layouts.app',  ['menu' => 'settings']);
    }

    public function page($value)
    {
        $this->page_name = $value;
    }
}
