<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class DashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard-component')
        ->layout('layouts.app',  ['menu' => 'dashboard']);
    }
}
