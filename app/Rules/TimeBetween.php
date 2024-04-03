<?php

namespace App\Rules;

use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Validation\Rule;
use DateTimeImmutable;
use InvalidArgumentException;

class TimeBetween implements Rule
{
    private $lotStartDate;
    private $lotEndDate;

    public function __construct($startDate, $endDate) {
        if ($startDate instanceof Carbon) {
            $startDate = $startDate->format('Y-m-d h:i A');
        }

        if ($endDate instanceof Carbon) {
            $endDate = $endDate->format('Y-m-d h:i A');
        }

        $this->lotStartDate = DateTimeImmutable::createFromFormat('Y-m-d h:i A', $startDate);
        $this->lotEndDate = DateTimeImmutable::createFromFormat('Y-m-d h:i A', $endDate);


        if (!$this->lotStartDate || !$this->lotEndDate) {
            throw new InvalidArgumentException('Invalid start or end date-time.');
        }
    }

    public function passes($attribute, $value) {
        // Create DateTime object for item time.
        $itemTime = DateTime::createFromFormat('H:i', $value);

        // If creation failed (due to invalid format, etc.), return false.
        if (!$itemTime) {
            return false;
        }

        if ($attribute === "start_time") {
            $itemDateTime = $this->lotStartDate->setTime((int) $itemTime->format('H'), (int) $itemTime->format('i'));
        } else {
            $itemDateTime = $this->lotEndDate->setTime((int) $itemTime->format('H'), (int) $itemTime->format('i'));
        }

        return ($itemDateTime >= $this->lotStartDate && $itemDateTime <= $this->lotEndDate);
    }

    public function message() {
        return 'The :attribute time must be between the selected lot start time and end time.';
    }
}
