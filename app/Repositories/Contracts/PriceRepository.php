<?php

namespace App\Repositories\Contracts;

use App\Model\Price;

interface PriceRepository
{
    public function create(array $data);

    public function update(Price $price, $data);

    public function delete(Price $price);
}
