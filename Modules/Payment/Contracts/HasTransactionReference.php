<?php

namespace Modules\Payment\Contracts;

interface HasTransactionReference
{
    /**
     * Get transaction reference
     *
     * @return string
     */
    public function getTransactionReference(): string;

    /**
     * Get meta
     *
     * @var array
     */
    public function getMeta(): array;
}
