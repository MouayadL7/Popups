<?php

namespace App\Contracts;

interface PopupAnalyticsStrategyContract
{
    public function calculate(int $limit = 10);
}
