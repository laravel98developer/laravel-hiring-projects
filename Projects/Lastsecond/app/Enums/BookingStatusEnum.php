<?php

namespace App\Enums;

enum BookingStatusEnum: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';

    /**
     * Returns the label for the current BookingStatusEnum value.
     *
     * @return string|null The label for the current BookingStatusEnum value.
     */
    public function getLabel(): ?string
    {
        // Use a match expression to return the label for the current BookingStatusEnum value.
        // If the value matches the Pending case, return the translated 'Pending' string.
        // If the value matches the Confirmed case, return the translated 'Confirmed' string.
        // If the value matches the Cancelled case, return the translated 'Cancelled' string.
        // Otherwise, return null.
        return match ($this) {
            static::Pending => __('Pending'), // Return the translated 'Pending' string.
            static::Confirmed => __('Confirmed'), // Return the translated 'Confirmed' string.
            static::Cancelled => __('Cancelled'), // Return the translated 'Cancelled' string.
        };
    }
}
