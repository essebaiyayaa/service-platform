<?php

namespace App\Livewire\Shared;

use Livewire\Component;

class Header extends Component
{
    public $menuOpen = false;

    public function toggleMenu()
    {
        $this->menuOpen = !$this->menuOpen;
    }

    public function render()
    {
        return view('livewire.shared.header');
    }
}