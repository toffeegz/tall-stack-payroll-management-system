<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class ProfileComponent extends Component
{
    public $user;
    public function mount()
    {
        $this->user = Auth::user();
    }
    public function render()
    {
        return view('livewire.profile.profile-component')
        ->layout('layouts.app',  ['menu' => 'profile']);
    }
}
