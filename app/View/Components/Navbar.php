<?php

namespace App\View\Components;

use App\Models\BookCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = BookCategory::orderBy('name', 'asc')->get();

        return view('components.navbar', [
            'navbarCategories' => $categories
        ]);
    }
}
