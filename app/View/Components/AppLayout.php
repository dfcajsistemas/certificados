<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $page;

    public function __construct($page='')
    {
        $this->page=$page;
    }

    public function render(): View
    {
        return view('layouts.app');
    }
}
