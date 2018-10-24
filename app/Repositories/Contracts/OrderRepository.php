<?php

namespace App\Repositories\Contracts;

use App\Model\Order;

interface OrderRepository
{
    public function create(array $data);

    public function update(Order $order, $data);

    public function delete(Order $order);
}
