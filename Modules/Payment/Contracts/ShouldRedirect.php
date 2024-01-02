<?php

namespace Modules\Payment\Contracts;

use Illuminate\Http\RedirectResponse;

interface ShouldRedirect
{
    /**
     * Get redirect url
     *
     * @return string|Illuminate\Http\RedirectResponse
     */
    public function getRedirectUrl(): string|RedirectResponse;
}
