<?php

namespace App\Repositories\Contracts;

use App\Model\OrderTake;

interface OrderTakeRepository
{
    public function create(array $data);

    public function update(OrderTake $orderTake, $data);

    public function delete(OrderTake $orderTake);
}
