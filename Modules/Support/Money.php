<?php

namespace Modules\Support;

use NumberFormatter;
use JsonSerializable;
use Modules\Support\Currency;

class Money implements JsonSerializable
{
    private $amount;
    private $currency;

    public function __construct($amount, $currency)
    {
        $this->amount = +$amount;
        $this->currency = $currency;
    }

    public static function inDefaultCurrency($amount)
    {
        return new self($amount, setting('default_currency'));
    }

    private function newInstance($amount)
    {
        return new self($amount, $this->currency);
    }

    public function amount()
    {
        return $this->amount;
    }

    public function subunit()
    {
        $fraction = 10 ** Currency::subunit($this->currency);

        return (int) round($this->amount * $fraction);
    }

    public function currency()
    {
        return $this->currency;
    }

    public function isZero()
    {
        return $this->amount == 0;
    }

    public function add(Money $addend)
    {
        return $this->newInstance($this->amount + $addend->amount);
    }

    public function subtract(Money $subtrahend)
    {

        return $this->newInstance($this->amount - $subtrahend->amount);
    }

    public function multiply($multiplier)
    {
        return $this->newInstance($this->amount * $multiplier);
    }

    public function divide($divisor)
    {
        return $this->newInstance($this->amount / $divisor);
    }

    public function lessThan($other)
    {
        return $this->amount < $other->amount;
    }

    public function lessThanOrEqual($other)
    {
        return $this->amount <= $other->amount;
    }

    public function greaterThan($other)
    {
        return $this->amount > $other->amount;
    }

    public function greaterThanOrEqual($other)
    {
        return $this->amount >= $other->amount;
    }

    public function round($precision = null, $mode = null)
    {
        if (is_null($precision)) {
            $precision = Currency::subunit($this->currency);
        }

        $amount = round($this->amount, $precision, $mode);

        return $this->newInstance($amount);
    }

    public function ceil()
    {
        return $this->newInstance(ceil($this->amount));
    }

    public function floor()
    {
        return $this->newInstance(floor($this->amount));
    }

    public function format($currency = null, $locale = null)
    {
        $currency = $currency ?: $this->currency;
        $locale = 'en';

        $numberFormatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        $amount = $numberFormatter->formatCurrency($this->amount, $currency);



        $amount = str_replace('.000', '', $amount);




        return $amount;
    }

    public function toArray()
    {
        return [
            'amount' => $this->amount,
            'formatted' => $this->format(),
            'currency' => $this->currency,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function __toString()
    {
        return (string) $this->amount;
    }
}