<?php

namespace Modules\Payment;

use Illuminate\Http\RedirectResponse;
use JsonSerializable;
use Modules\Payment\Contracts\ShouldRedirect;

abstract class GatewayResponse implements JsonSerializable
{
    /**
     * Get entity type
     *
     * @return string
     */
    abstract public function getEntityType(): string;

    /**
     * Get entity id
     *
     * @return string|int
     */
    abstract public function getEntityId(): string|int;

    /**
     * Get entity reference no
     *
     * @return string
     */
    abstract public function getEntityReferenceNo(): string;


    public function toArray()
    {
        $data = [
            "id" => $this->getEntityId(),
            "reference_no" => $this->getEntityReferenceNo()
        ];

        if ($this instanceof ShouldRedirect) {
            $redirectUrl =  $this->getRedirectUrl();
            $data['redirectUrl'] = $redirectUrl instanceof RedirectResponse ? $redirectUrl->getTargetUrl() : $redirectUrl;
        }

        return $data;
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
