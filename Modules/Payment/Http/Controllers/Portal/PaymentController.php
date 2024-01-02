<?php

namespace Modules\Payment\Http\Controllers\Portal;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Routing\Controller;

class PaymentController extends Controller
{
    public function index(string $payload)
    {
        try {
            $payload = decrypt($payload);
        } catch (DecryptException $e) {
            abort(404);
        }
    
        return view('hyperpay.index', ['payload' => $payload, 'logo' => getMedia(setting('portal_payment_logo'))->url]);
    }
}
