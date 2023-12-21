<?php

namespace Modules\Dashboard\Http\ViewComposers;



class LayoutComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose($view)
    {
        $settings = auth()->check() ? auth()->user()->settings : [];

        $view->with('uiOptions', [
            'sidebar_size' => \Arr::get($settings, 'sidebar_size', 'lg'),
            'layout_mode' => \Arr::get($settings, 'layout_mode', 'light'),
            'fav_icon' => getMedia(setting('dashboard_fav_icon'))->url,
        ]);
    }
}