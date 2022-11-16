<?php

namespace App\Traits;
use DateTimeInterface;

trait HasDateTimeFormatter
{
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date;
    }
}
