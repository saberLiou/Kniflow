<?php

namespace App\Models\Traits;

trait DateTimeFormatted
{
    /**
     * Prepare a datetime with correct timezone for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
