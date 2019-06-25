<?php

namespace App\Http\Composers;

use App\Models\Box\Status;
use App\Models\Location\Location;
use Illuminate\View\View;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('logged_in_user', access()->user());
        $view->with('locations', Location::all()->pluck('name', 'id'));
        $view->with('stats', Status::all()->pluck('label', 'id'));
    }
}
