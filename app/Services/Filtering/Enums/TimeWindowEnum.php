<?php

namespace App\Services\Filtering\Enums;

class TimeWindowEnum
{
    const LATEST = 'latest';
    const ONE_DAY_AGO = '-1d';
    const WITHIN_N_DAYS_AGO = '-wnd';
    const N_DAYS_AGO = '-nd';
}
