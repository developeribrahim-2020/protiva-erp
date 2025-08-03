<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PublicLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // পরিবর্তন এখানে: layouts.public ভিউটি রেন্ডার করা হচ্ছে
        return view('layouts.public');
    }
}