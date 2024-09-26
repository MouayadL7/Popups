<?php

namespace App\Contracts;

interface PopupRetrievalStrategyContract
{
    public function getPopups(array $data);
}
