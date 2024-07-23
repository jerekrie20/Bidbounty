<?php

namespace App\Rules;

use Closure;
use DateTime;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class DateTimeBetween implements Rule
{

    private $startDate;
    private $endDate;

    public function __construct(DateTime $startDate, DateTime $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function passes($attribute, $value)
    {
        $itemDate = new DateTime($value);

        return $itemDate >= $this->startDate && $itemDate <= $this->endDate;
    }

    public function message()
    {
        return 'The :attribute datetime must be between the selected lot start date and end date.';
    }
}
