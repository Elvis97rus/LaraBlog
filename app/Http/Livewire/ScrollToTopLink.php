<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ScrollToTopLink extends Component
{
    public function render()
    {
        return view('livewire.scroll-to-top-link');
    }

    public function scrollToTop()
    {
        $this->dispatchBrowserEvent('scroll-to-top');
    }
}
